import * as cdk from 'aws-cdk-lib';
import { Construct } from 'constructs';

export interface IResolverDataSorce {
    [key: string]: cdk.aws_appsync.DynamoDbDataSource;
}

export interface IResolver {
    scope: Construct;
    api: cdk.aws_appsync.GraphqlApi;
    dataSource: IResolverDataSorce;
}