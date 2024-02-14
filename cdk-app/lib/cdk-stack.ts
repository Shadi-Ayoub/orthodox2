import * as cdk from 'aws-cdk-lib';
import * as appsync from 'aws-cdk-lib/aws-appsync';
import * as cognito from 'aws-cdk-lib/aws-cognito';
// import * as iam from 'aws-cdk-lib/aws-iam';
import { CognitoIdentityProviderClient, UpdateUserPoolClientCommand } from "@aws-sdk/client-cognito-identity-provider";
import { Construct } from 'constructs';

import SchemaGenerator from './Schema/lib/SchemaGenerator';
import * as datasource from "./DataSources";
import {IResolverFunction, ResolverType} from './Resolvers/ResolverTypes';
import * as constants from './Resolvers/Functions/Constants';
import * as functionCodes from './Resolvers/Functions/Codes';
import * as resolverCodes from './Resolvers/codes';

require('dotenv').config({path : __dirname + '/../../.env'});

/**
 * Create the following in sequence:
 * 1- Data Source(s)
 * 2- Function Code
 * 3- Function
 * 4- Pipline Resolver
 * 5- Schema Types/Queries/Mutations
 */
export class CdkStack extends cdk.Stack {
  apiName: string;
  api:appsync.GraphqlApi;

  congregationDataSource: appsync.DynamoDbDataSource;
  congregationTable: cdk.aws_dynamodb.Table;
  
  branchDataSource: appsync.DynamoDbDataSource;
  branchTable: cdk.aws_dynamodb.Table;

  settingDataSource: appsync.DynamoDbDataSource;
  settingTable: cdk.aws_dynamodb.Table;

  constructor(scope: Construct, id: string, props?: cdk.StackProps) {
    super(scope, id, props);

    this.apiName = 'FaithHubSpotAPI-V1';

    // Generate the Schema file from the schema files
    SchemaGenerator();
    
/*===============================API Definition==============================*/

    // Reference the existing Cognito User Pools
    const adminUserPoolId = process.env.COGNITO_ADMIN_USER_POOL_ID as string;
    const userUserPoolId = process.env.COGNITO_USER_POOL_ID as string;
    const userPoolAdmin = cognito.UserPool.fromUserPoolId(this, 'AdminUserPool', adminUserPoolId);
    const userPoolUser = cognito.UserPool.fromUserPoolId(this, 'NormalUserPool', userUserPoolId);

    this.api = new appsync.GraphqlApi(this, this.apiName, {
      name: this.apiName,
      definition: appsync.Definition.fromFile('lib/Schema/Schema.generated.graphql'),
      authorizationConfig: {
        defaultAuthorization: {
          authorizationType: appsync.AuthorizationType.USER_POOL,
          userPoolConfig: {
            userPool: userPoolAdmin,
          },
        },
        additionalAuthorizationModes: [
          {
            authorizationType: appsync.AuthorizationType.USER_POOL,
            userPoolConfig: {
              userPool: userPoolUser,
            },
          },
          // You can add other authorization modes here (e.g., API_KEY, IAM, OIDC)
        ],
      },
    });

/*===========================================================================*/

/*=============================Print Information=============================*/

    // Prints out URL
    new cdk.CfnOutput(this, "GraphQLAPIURL", {
      value: this.api.graphqlUrl
    });

    // Prints out the AppSync GraphQL API key to the terminal
    new cdk.CfnOutput(this, "GraphQLAPIKey", {
      value: this.api.apiKey || ''
    });

    // Prints out the stack region to the terminal
    new cdk.CfnOutput(this, "Stack Region", {
      value: this.region
    });

/*===========================================================================*/

/*==========================Create the Data Sources==========================*/

    const resultCongregationDataSource  = this.createDataSource(datasource.createCongregationDataSource);
    this.congregationDataSource = resultCongregationDataSource.ds;
    this.congregationTable = resultCongregationDataSource.ddbTable;

    const resultBranchDataSource = this.createDataSource(datasource.createBranchDataSource);
    this.branchDataSource = resultBranchDataSource.ds;
    this.branchTable = resultBranchDataSource.ddbTable;

    const resultSettingDataSource = this.createDataSource(datasource.createSettingDataSource);
    this.settingDataSource = resultSettingDataSource.ds;
    this.settingTable = resultSettingDataSource.ddbTable;

/*==========================End of Data Sources Section======================*/

/*=======================Create the Functions (Operations)===================*/

/* Congregations */

    // Creates a function for getting a Congregation
    const param: IResolverFunction = {
      name: constants.FUNCTION_NAME_GET_CONGREGATIONS,
      scope: this,
      api: this.api,
      dataSource: this.congregationDataSource,
      code: functionCodes.funcGetCongregationsCode,
    }
    const funcGetCongregations = this.createFunction(param);
    
    // Creates a function for adding Congregations
    param.name = constants.FUNCTION_NAME_ADD_CONGREGATION;
    param.dataSource = this.congregationDataSource,
    param.code = functionCodes.funcAddCongregationCode;
    const funcAddCongregation = this.createFunction(param);

    // Creates a function for getting Congregations
    param.name = constants.FUNCTION_NAME_GET_CONGREGATIONS_BY_ID;
    param.dataSource = this.congregationDataSource,
    param.code = functionCodes.funcGetCongregationsByIdCode;
    const funcGetCongregationsById = this.createFunction(param);

/* Branches */

    // Creates a function for adding a Branch under a Congregation
    param.name = constants.FUNCTION_NAME_ADD_BRANCH;
    param.dataSource = this.branchDataSource;
    param.code = functionCodes.funcAddBranchCode;
    const funcAddBranch = this.createFunction(param);

    // Creates a function for getting all Branches under a Congregation
    param.name = constants.FUNCTION_NAME_GET_ALL_BRANCHES_BY_CONGREGATION_ID;
    param.dataSource = this.branchDataSource;
    param.code = functionCodes.funcGetAllBranchesByCongregationIdCode;
    const funcGetAllBranchesByCongregationId = this.createFunction(param);

/* Settings */

    // Creates a function for getting all Branches under a Congregation
    param.name = constants.FUNCTION_NAME_GET_ALL_SETTINGS;
    param.dataSource = this.settingDataSource;
    param.code = functionCodes.funcGetAllSettingsCode;
    const funcGetAllSettings = this.createFunction(param);

    // Creates a function for updating settings by id (updating a settings section)
    param.name = constants.FUNCTION_NAME_UPDATE_SETTINGS_BY_ID;
    param.dataSource = this.settingDataSource;
    param.code = functionCodes.funcUpdateSettingsByIdCode;
    const funcUpdateSettingsById = this.createFunction(param);

    // Creates a function for updating settings (all or selected depending on the passed object)
    param.name = constants.FUNCTION_NAME_UPDATE_SETTINGS;
    param.dataSource = this.settingDataSource;
    param.code = functionCodes.funcUpdateSettingsCode;
    const funcUpdateSettings = this.createFunction(param);

/*============================End of Functions Section=======================*/

/*=============================Create the Resolvers==========================*/

    this.createBasicPipelineResolver('getAllSettings', ResolverType.Query, [funcGetAllSettings]);
    this.createBasicPipelineResolver('updateSettingsById', ResolverType.Mutation, [funcUpdateSettingsById]);
    this.createBasicPipelineResolver('updateSettings', ResolverType.Mutation, [funcUpdateSettings]);

    this.createBasicPipelineResolver('getAllCongregations', ResolverType.Query, [funcGetCongregations]);
    this.createBasicPipelineResolver('getCongregationsById', ResolverType.Query, [funcGetCongregationsById]);
    this.createBasicPipelineResolver('addCongregation', ResolverType.Mutation, [funcAddCongregation]);
    
    this.createBasicPipelineResolver('getAllBranchesByCongregationId', ResolverType.Query, [funcGetAllBranchesByCongregationId]);
    this.createBasicPipelineResolver('addBranch', ResolverType.Mutation, [funcAddBranch]);

/*============================End of Resolvers Section=======================*/

/*===============================Initial Configurations===========================*/
// (async () => {
//   const adminUserPoolId = process.env.COGNITO_ADMIN_USER_POOL_ID as string;
//   const userUserPoolId = process.env.COGNITO_USER_POOL_ID as string;
//   const clientId = process.env.COGNITO_APP_CLIENT_ID as string;;

//   // Set both access and ID token expiry to 1 hour and refresh token to 30 days
//   await this.updateTokenExpiry(adminUserPoolId, clientId, 60, 60,30);
//   await this.updateTokenExpiry(userUserPoolId, clientId, 60, 60, 30);
// })();
/*============================End of Configurations Section=======================*/


  }

  /**
   * 
   * @param func 
   * @returns 
   */
  createDataSource(func: (input: datasource.IDataSource) => {ds: cdk.aws_appsync.DynamoDbDataSource,ddbTable: cdk.aws_dynamodb.Table} ) {
    const paramDataSource: datasource.IDataSource = {
      scope: this,
      api: this.api,
    }

    return func(paramDataSource);
  }

  /**
   * 
   * @param input 
   * @returns 
   */
  createFunction(input: IResolverFunction) {
    return new appsync.AppsyncFunction(
      input.scope, 
      input.name, 
      {
        name: input.name,
        api: input.api,
        dataSource: input.dataSource,
        code: appsync.Code.fromInline(input.code),
        runtime: appsync.FunctionRuntime.JS_1_0_0,
      });
  }

  /**
   * 
   * @param fieldName 
   * @param resolverType 
   * @param functions 
   */
  createBasicPipelineResolver(fieldName: string, resolverType: ResolverType, functions: [appsync.AppsyncFunction]) {
    const id = 'pipelineResolver' + fieldName.charAt(0).toUpperCase() + fieldName.slice(1);
    new appsync.Resolver(this, id, {
      api: this.api,
      typeName: resolverType,
      fieldName: fieldName,
      code: appsync.Code.fromInline(resolverCodes.resolverRequestCode1 + resolverCodes.resolverResponseCode1),
      runtime: appsync.FunctionRuntime.JS_1_0_0,
      pipelineConfig: functions,
    });
   
  }

  async updateTokenExpiry(userPoolId: string, clientId: string, accessTokenValidity: number = 60, idTokenValidity: number = 60, refreshTokenValidity: number = 30): Promise<void> {
    const command = new UpdateUserPoolClientCommand({
      UserPoolId: userPoolId,
      ClientId: clientId,
      AccessTokenValidity: accessTokenValidity,
      IdTokenValidity: idTokenValidity,
      RefreshTokenValidity: refreshTokenValidity,
    });

    try {
      const region = process.env.COGNITO_REGION as string;
      const client = new CognitoIdentityProviderClient({ region });
      const response = await client.send(command);
      console.log(`Token expiry updated for User Pool Client: ${clientId}`, response);
    } catch (error) {
      console.error(`Error updating token expiry for User Pool Client: ${clientId}`, error);
    }
  }
}