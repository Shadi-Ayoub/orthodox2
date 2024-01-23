import * as cdk from 'aws-cdk-lib';
import { Construct } from 'constructs';

export interface IDataSource {
    scope: Construct;
    api: cdk.aws_appsync.GraphqlApi;
}