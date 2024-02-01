import * as cdk from 'aws-cdk-lib';
import { Template } from 'aws-cdk-lib/assertions';
import * as Cdk from '../../lib/cdk-stack';

require('dotenv').config({path : __dirname + '/../../.env'}); // load environment variables into process.env
const removal_policy = process.env.MODE == "DEVELOPMENT" ? 'Delete' : 'Retain';

const congregationsTable = 'FaithHubSpotCongregationTable';
const branchesTable = 'FaithHubSpotBranchTable';

const app = new cdk.App();
const stack = new Cdk.CdkStack(app, 'MyTestStack');
const template = Template.fromStack(stack);

// Assert that all DynamoDB tables are created!
test('DYNAMODB-TEST 1: All DynamoDB Tables are created', () => {
    template.resourceCountIs('AWS::DynamoDB::Table', 2);
});

// Assert that the DynamoDB Congregations table resource is created correctly!
test('DYNAMODB-TEST 2: Congregations Table is correctly Created', () => {
    const table = template.findResources('AWS::DynamoDB::Table', {
        Properties: {
            TableName: congregationsTable
        }
    });

    // Get the keys (logical IDs) of the found tables
    const tableKeys = Object.keys(table);

    // Expect that at least one table with the specific tableName exists
    expect(tableKeys.length).toBeGreaterThan(0);

    // Get the properties of the table
    const tableProperties = table[tableKeys[0]].Properties;

    // Get the table resource to check its properties
    const resourceDefinition = table[tableKeys[0]];

    // Assert the AttributeDefinitions
    expect(tableProperties.AttributeDefinitions).toEqual([
        { AttributeName: 'id', AttributeType: 'S' },
        //{ AttributeName: 'sortKey', AttributeType: 'N' }
        // ... add other attribute definitions if needed
    ]);

    // Assert the KeySchema
    expect(tableProperties.KeySchema).toEqual([
        { AttributeName: 'id', KeyType: 'HASH' },
        // { AttributeName: 'sortKey', KeyType: 'HASH' }
    // ... add other key schema elements if needed
    ]);

    // Assert the ProvisionedThroughput
    expect(tableProperties.ProvisionedThroughput).toEqual(
        {
            ReadCapacityUnits: 5,
            WriteCapacityUnits: 5
        },
    );

    // Assert the BillingMode
    const billingMode = tableProperties.BillingMode; // If undefined then the default is set which is 'PROVISIONED'
    expect(billingMode === undefined || billingMode === 'PROVISIONED').toBeTruthy();

    expect(resourceDefinition.UpdateReplacePolicy).toEqual(removal_policy);
    expect(resourceDefinition.DeletionPolicy).toEqual(removal_policy);
});

// Assert that the DynamoDB Branches table resource is created correctly!
test('DYNAMODB-TEST 2: Branches Table is correctly Created', () => {
    const table = template.findResources('AWS::DynamoDB::Table', {
        Properties: {
            TableName: branchesTable
        }
    });

    // Get the keys (logical IDs) of the found tables
    const tableKeys = Object.keys(table);

    // Expect that at least one table with the specific tableName exists
    expect(tableKeys.length).toBeGreaterThan(0);

    // Get the properties of the table
    const tableProperties = table[tableKeys[0]].Properties;

    // Get the table resource to check its properties
    const resourceDefinition = table[tableKeys[0]];

    // Assert the AttributeDefinitions
    expect(tableProperties.AttributeDefinitions).toEqual([
        { AttributeName: 'id', AttributeType: 'S' },
        { AttributeName: 'congregationId', AttributeType: 'S' },
    ]);

    // Assert the KeySchema
    expect(tableProperties.KeySchema).toEqual([
        { AttributeName: 'id', KeyType: 'HASH' },
    ]);

    // Assert the Indexes
    expect(tableProperties.GlobalSecondaryIndexes).toEqual([
        {
            IndexName: "congregation-index",
            KeySchema: [
                {
                    AttributeName: "congregationId",
                    KeyType: "HASH"
                }
            ],
            Projection: {
                ProjectionType: "ALL"
            },
            ProvisionedThroughput: {
                ReadCapacityUnits: 5,
                WriteCapacityUnits: 5
            }
        }
    ]);

    // Assert the ProvisionedThroughput
    expect(tableProperties.ProvisionedThroughput).toEqual(
        {
            ReadCapacityUnits: 5,
            WriteCapacityUnits: 5
        },
    );

    // Assert the BillingMode
    const billingMode = tableProperties.BillingMode; // If undefined then the default is set which is 'PROVISIONED'
    expect(billingMode === undefined || billingMode === 'PROVISIONED').toBeTruthy();

    expect(resourceDefinition.UpdateReplacePolicy).toEqual(removal_policy);
    expect(resourceDefinition.DeletionPolicy).toEqual(removal_policy);
});
