import * as cdk from 'aws-cdk-lib';
import { Construct } from 'constructs';

export enum ResolverType {
    Query = "Query",
    Mutation = "Mutation"
}

export interface IResolverFunction {
    name: string;
    scope: Construct;
    api: cdk.aws_appsync.GraphqlApi;
    dataSource: cdk.aws_appsync.DynamoDbDataSource;
    code: string;
}