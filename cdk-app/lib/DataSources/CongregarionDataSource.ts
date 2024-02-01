//Create the Congregations Data Sources
import * as cdk from 'aws-cdk-lib';
import * as dynamodb from 'aws-cdk-lib/aws-dynamodb';

import {IDataSource} from './DataSourceTypes';

require('dotenv').config({path : __dirname + '/../../.env'}); // load environment variables into process.env

export default function createCongregationDataSource(input: IDataSource){
  const removal_policy = process.env.MODE == "DEVELOPMENT" ? cdk.RemovalPolicy.DESTROY : cdk.RemovalPolicy.RETAIN;

  //Creates a DDB table
  const ddbTable = new dynamodb.Table(input.scope, "FaithHubSpotCongregationTable", {
    tableName: "FaithHubSpotCongregationTable",
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
  // ddbTable.addGlobalSecondaryIndex({
  //   indexName: 'code-index',
  //   partitionKey: {
  //     name: 'code',
  //     type: dynamodb.AttributeType.STRING,
  //   },
  //   projectionType: dynamodb.ProjectionType.ALL,
  // });

  // Create the data source
  const ds = input.api.addDynamoDbDataSource('CongregationDataSource', ddbTable);
  
  return {ds, ddbTable};
}