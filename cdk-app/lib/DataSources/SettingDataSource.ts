//Create the Congregations Data Sources
import * as cdk from 'aws-cdk-lib';
import * as dynamodb from 'aws-cdk-lib/aws-dynamodb';

import {IDataSource} from './DataSourceTypes'

// load environment variables into process.env
require('dotenv').config({path : __dirname + '/../../.env'});

export default function createSettingDataSource(input: IDataSource){
  const removal_policy = process.env.MODE == "DEVELOPMENT" ? cdk.RemovalPolicy.DESTROY : cdk.RemovalPolicy.RETAIN;

  //Creates a DDB table
  const ddbTable = new dynamodb.Table(input.scope, "FaithHubSpotSettingTable", {
    tableName: "FaithHubSpotSettingTable",
    partitionKey: {
      name: "id",
      type: dynamodb.AttributeType.STRING,
    },
    billingMode: dynamodb.BillingMode.PROVISIONED,
    removalPolicy: removal_policy,
  });

  // Create the data source
  const ds = input.api.addDynamoDbDataSource('SettingDataSource', ddbTable);
  
  return {ds, ddbTable};
}