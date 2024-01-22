//Create the Congregations Data Sources
import * as cdk from 'aws-cdk-lib';
import * as dynamodb from 'aws-cdk-lib/aws-dynamodb';
import { Construct } from 'constructs';

export default function createCongregationsDataSource(scope: Construct, api: cdk.aws_appsync.GraphqlApi){
    //Creates a DDB table
    const ddbTable = new dynamodb.Table(scope, "FaithHubSpotCongregationsTable", {
      tableName: "FaithHubSpotCongregationsTable",
      partitionKey: {
        name: "id",
        type: dynamodb.AttributeType.STRING,
      },
      sortKey: {
        name: 'nameEnglish',
        type: dynamodb.AttributeType.STRING,
      },
      billingMode: dynamodb.BillingMode.PROVISIONED,
      removalPolicy: cdk.RemovalPolicy.RETAIN,
    });

    // Create extra Index
    ddbTable.addGlobalSecondaryIndex({
      indexName: 'code-index',
      partitionKey: {
        name: 'code',
        type: dynamodb.AttributeType.STRING,
      },
      projectionType: dynamodb.ProjectionType.ALL,
    });

    // Create the data source
    return api.addDynamoDbDataSource('CongregationsDataSource', ddbTable);
  }