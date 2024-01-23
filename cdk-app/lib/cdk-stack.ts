import * as cdk from 'aws-cdk-lib';
import * as appsync from 'aws-cdk-lib/aws-appsync';
import { Construct } from 'constructs';

import * as datasource from "./DataSources";
import * as resolver from "./Resolvers";

export class CdkStack extends cdk.Stack {
  api:appsync.GraphqlApi;
  congregationDataSource: appsync.DynamoDbDataSource;

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
    this.congregationDataSource = this.createDataSource(datasource.createCongregationDataSource);

    // Create Resolvers
    this.createResolver(resolver.createCongregationResolver, {Congregation: this.congregationDataSource});
  }

  createDataSource(func: (input: datasource.IDataSource) => cdk.aws_appsync.DynamoDbDataSource ) {
    const paramDataSource: datasource.IDataSource = {
      scope: this,
      api: this.api,
    }

    return func(paramDataSource);
  }

  createResolver(func: (input: resolver.IResolver) => void, ds: resolver.IResolverDataSorce) {
    const paramResolver: resolver.IResolver = {
      scope: this,
      api: this.api,
      dataSource: ds,
    }
    func(paramResolver);
  }
}