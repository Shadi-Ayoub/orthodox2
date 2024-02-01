//Create the Congregations Data Sources
import * as cdk from 'aws-cdk-lib';
import * as dynamodb from 'aws-cdk-lib/aws-dynamodb';

import {IDataSource} from './DataSourceTypes'

// load environment variables into process.env
require('dotenv').config({path : __dirname + '/../../.env'});

export default function createBranchDataSource(input: IDataSource){
  const removal_policy = process.env.MODE == "DEVELOPMENT" ? cdk.RemovalPolicy.DESTROY : cdk.RemovalPolicy.RETAIN;

  //Creates a DDB table
  const ddbTable = new dynamodb.Table(input.scope, "FaithHubSpotBranchTable", {
    tableName: "FaithHubSpotBranchTable",
    partitionKey: {
      name: "id",
      type: dynamodb.AttributeType.STRING,
    },
    // sortKey: {
    //   name: 'nameEnglish',
    //   type: dynamodb.AttributeType.STRING,
    // },
    billingMode: dynamodb.BillingMode.PROVISIONED,
    removalPolicy: removal_policy,
  });

  // Create extra Index
  ddbTable.addGlobalSecondaryIndex({
    indexName: 'congregation-index',
    partitionKey: {
      name: 'congregationId',
      type: dynamodb.AttributeType.STRING,
    },
    projectionType: dynamodb.ProjectionType.ALL,
  });

  // Create the data source
  const ds = input.api.addDynamoDbDataSource('BranchDataSource', ddbTable);
  
  return {ds, ddbTable};
}