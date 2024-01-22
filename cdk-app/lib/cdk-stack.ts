import * as cdk from 'aws-cdk-lib';
import * as appsync from 'aws-cdk-lib/aws-appsync';
// import * as dynamodb from 'aws-cdk-lib/aws-dynamodb';
import { Construct } from 'constructs';

import * as datasources from "./DataSources"
// import { Role, ServicePrincipal, ManagedPolicy } from 'aws-cdk-lib/aws-iam';
// import * as sqs from 'aws-cdk-lib/aws-sqs';

export class CdkStack extends cdk.Stack {
  api:appsync.GraphqlApi;
  // congregationsTable: cdk.aws_dynamodb.Table;
  congregationsDataSource: appsync.DynamoDbDataSource;

  constructor(scope: Construct, id: string, props?: cdk.StackProps) {
    super(scope, id, props);

    // Create the GraphQL API
    this.api = new appsync.GraphqlApi(this, 'FaithHubSpotAPI-V1', {
      name: 'FaithHubSpot-api-v1',
      definition: appsync.Definition.fromFile('schema/schema.graphql'),
    });

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

    // Create the Congregations Data Sources
    // this.congregationsTable = this.createCongregationsTable();
    // this.congregationsDataSource = this.api.addDynamoDbDataSource('CongregationsDataSource', this.congregationsTable);

    // datasources.createCongregationsDataSource(this, this.api, this.congregationsTable, this.congregationsDataSource);
    this.congregationsDataSource = datasources.createCongregationsDataSource(this, this.api);
    // Prints out the stack region to the terminal
    // new cdk.CfnOutput(this, "Data source name", {
    //   value: this.congregationsDataSource.name
    // });

    // Create Resolvers
    this.createCongregationsResolvers();
  }

  createCongregationsResolvers() {
    // Creates a function for query
    const funcGetCongregations = new appsync.AppsyncFunction(this, 'funcGetCongregations', {
      name: 'funcGetCongregations',
      api: this.api,
      dataSource: this.congregationsDataSource,
      code: appsync.Code.fromInline(
        `export function request(ctx) {
          return { operation: 'Scan' };
        }

        export function response(ctx) {
          return ctx.result.items;
        }`
      ),
      runtime: appsync.FunctionRuntime.JS_1_0_0,
    });

    // Creates a function for mutation
    const funcAddCongregation = new appsync.AppsyncFunction(this, 'funcAddCongregation', {
      name: 'funcAddCongregation',
      api: this.api,
      dataSource: this.congregationsDataSource,
      code: appsync.Code.fromInline(
        `import { runtime, util } from '@aws-appsync/utils'
        export function request(ctx) {
          // runtime.earlyReturn({ id: ctx.args.input.nameEnglish })
          // const date = Date.now().toString();
          return {
            operation: 'PutItem',
            key: util.dynamodb.toMapValues({id: util.autoId()}),
            attributeValues: util.dynamodb.toMapValues(ctx.args.input),
          };
        }

        export function response(ctx) {
          return ctx.result;
        }`
      ),
      runtime: appsync.FunctionRuntime.JS_1_0_0,
    });

    // Adds a pipeline resolver with the get function
    new appsync.Resolver(this, 'pipelineResolverGetCongregations', {
      api: this.api,
      typeName: 'Query',
      fieldName: 'getAllCongregations',
      code: appsync.Code.fromInline(
        `export function request(ctx) {
          return {};
        }

        export function response(ctx) {
          return ctx.prev.result;
        }`
      ),
      runtime: appsync.FunctionRuntime.JS_1_0_0,
      pipelineConfig: [funcGetCongregations],
    });

    // Adds a pipeline resolver with the add function
    new appsync.Resolver(this, 'pipelineResolverAddCongregation', {
      api: this.api,
      typeName: 'Mutation',
      fieldName: 'addCongregation',
      code: appsync.Code.fromInline(
        `export function request(ctx) {
          return {};
        }

        export function response(ctx) {
          return ctx.prev.result;
        }`
      ),
      runtime: appsync.FunctionRuntime.JS_1_0_0,
      pipelineConfig: [funcAddCongregation],
    });
  }
}
