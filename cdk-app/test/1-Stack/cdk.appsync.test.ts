// import * as AWS from 'aws-sdk';
import {  AppSyncRuntime, 
          AppSyncClient, 
          EvaluateCodeCommand, 
          EvaluateCodeCommandInput } from '@aws-sdk/client-appsync';

import { unmarshall } from '@aws-sdk/util-dynamodb';
import { print } from '../lib';
// import { readFileSync } from 'fs';

import * as functionCodes from '../../lib/Resolvers/Functions/Codes';

const region = 'us-east-1';
const client = new AppSyncClient({ region });
const runtime: AppSyncRuntime = { name: 'APPSYNC_JS', runtimeVersion: '1.0.0' };

// interface EvaluationResult {
//     key?: {
//         id?: { S?: string;};
//     };
//     attributeValues?: {
//         congregationId?: { S?: string; };
//         nameEnglish?: { S?: string; };
//         nameNative?: { S?: string; };
//         city?: { S?: string; };
//         country?: { S?: string; };
//         contactNo1?: { S?: string; };
//         contactNo2?: { S?: string; };
//         email?: { S?: string; };
//         addressLine1?: { S?: string; };
//         addressLine2?: { S?: string; };
//     };
// }

test('APPSYNC-TEST 1: AddCongregation Resolver', async () => {
  const code = functionCodes.funcAddCongregationCode;

  const context = {
    "arguments": {
      "input": {
        "addressLine1": "Addrerss Line 1",
        "addressLine2": "Address Line 2",
        "city": "Dubai",
        "contactNo1": "123456",
        "contactNo2": "123456",
        "country": "uae",
        "email": "email@domain.com",
        "nameEnglish": "Greek Orthodox Archbishopric in UAE",
        "nameNative": "مطرانية الروم الأرثوذكس في الإمارات"
      }
    },
  };

  const input: EvaluateCodeCommandInput = {
    runtime: runtime,
    code: code,
    context: JSON.stringify(context),
    function: 'request',
  };

  const evaluateCodeCommand = new EvaluateCodeCommand(input);

  // Act
  const response = await client.send(evaluateCodeCommand);

  //Assert
  // Ensure that evaluationResult is a valid JSON string
  expect(response).toBeDefined();
  expect(response.error).toBeUndefined();
  expect(response.evaluationResult).toBeDefined();

  const result = JSON.parse(response.evaluationResult ?? '{}');

  // print({key: "result", value: result})

  // return;

  // console.log(result[0].toString());

  // expect(result.length).toEqual(2);

  expect(result.operation).toEqual('PutItem');
  expect(result.key?.id?.S).toBeDefined();
  expect(result.attributeValues?.addressLine1?.S).toEqual(context.arguments.input.addressLine1);
  expect(result.attributeValues?.addressLine2?.S).toEqual(context.arguments.input.addressLine2);
  expect(result.attributeValues?.city?.S).toEqual(context.arguments.input.city);
  expect(result.attributeValues?.contactNo1?.S).toEqual(context.arguments.input.contactNo1);
  expect(result.attributeValues?.contactNo2?.S).toEqual(context.arguments.input.contactNo2);
  expect(result.attributeValues?.country?.S).toEqual(context.arguments.input.country);
  expect(result.attributeValues?.email?.S).toEqual(context.arguments.input.email);
  expect(result.attributeValues?.nameEnglish?.S).toEqual(context.arguments.input.nameEnglish);
  expect(result.attributeValues?.nameNative?.S).toEqual(context.arguments.input.nameNative);

})

test('APPSYNC-TEST 2: GetAllBranchesByCongregationId Resolver', async () => {
  const code = functionCodes.funcGetAllBranchesByCongregationIdCode;
  // const context: string = readFileSync(__dirname + '/Context/context-get-all-branches-by-congregation-id.json', 'utf8');
  const context = {
    "arguments": {
      "congregationId": "2dfee7ad-d655-4d6d-86f7-f3ac142f3d19",
      "limit": 20
    },
    // "result": {
    //   "branches": [{
    //       "id": 'b768fef9-0ae7-48d1-b575-02162a6cc01b',
    //       "congregationId": '4064ec4e-18e6-4410-83a1-54865e12f6f8',
    //       "nameEnglish": 'Greek Orthodox Archbishopric in UAE',
    //       "nameNative": 'مطرانية الروم الأرثوذكس في الإمارات',
    //       "city": 'Dubai',
    //       "country": 'UAE',
    //       "contactNo1": '123456',
    //       "contactNo2": '123456',
    //       "email": 'email@orthodox.com',
    //       "addressLine1": 'address-line 1',
    //       "addressLine2": 'address-line 2'
    //   }],
    //   "nextToken": ""
    // },
  };
  // const contextJSON = JSON.parse(context);

  // const contextJSON = JSON.stringify(context);

  const input: EvaluateCodeCommandInput = {
    runtime: runtime,
    // code: await readFile(file, { encoding: 'utf8' }),
    code: code,
    context: JSON.stringify(context),
    function: 'request',
  };

  const evaluateCodeCommand = new EvaluateCodeCommand(input);

  // Act
  const response = await client.send(evaluateCodeCommand);

  //Assert
  // Ensure that evaluationResult is a valid JSON string
  expect(response).toBeDefined();
  expect(response.error).toBeUndefined();
  expect(response.evaluationResult).toBeDefined();

  const result = JSON.parse(response.evaluationResult ?? '{}');

  // Object.prototype.toString = function(){
  //   return JSON.stringify(this)
  // }

  // console.log("response: " + response.toString());

  expect(result.operation).toEqual('Query');
  expect(result.query.expression).toEqual('(#congregationId = :congregationId_eq)');
  
  const expressionValues = unmarshall(result.query.expressionValues); // Convert DynamoDB Record into JavaScript object

  // console.log("expressionValues: " + expressionValues.toString());

  expect(expressionValues[':congregationId_eq']).toEqual(context.arguments.congregationId);

  // let result: EvaluationResult;
  
  // if (typeof response.evaluationResult === 'string') {
  //   try {
  //     result = JSON.parse(response.evaluationResult);
  //   } catch (error) {
  //     throw new Error('evaluationResult is not a valid JSON string');
  //   }
  // } else {
  //   throw new Error('evaluationResult is undefined or not a string');
  // }

  // console.log("code: " + code);
  // console.log("context: " + context);
  // console.log("runtime: " + runtime.toString());
  // console.log("response: " + response.toString());
  // console.log(response.evaluationResult);

  // Perform assertions on the parsed result
  // expect(result.key?.id?.S).toBeDefined();
  // expect(result.attributeValues?.nameEnglish?.S).toEqual(contextJSON.arguments.nameEnglish);
  // expect(result.attributeValues?.nameNative?.S).toEqual(contextJSON.arguments.nameNative);
  // expect(result.attributeValues?.city?.S).toEqual(contextJSON.arguments.city);
  // expect(result.attributeValues?.country?.S).toEqual(contextJSON.arguments.country);
  // expect(result.attributeValues?.contactNo1?.S).toEqual(contextJSON.arguments.contactNo1);
  // expect(result.attributeValues?.contactNo2?.S).toEqual(contextJSON.arguments.contactNo2);
  // expect(result.attributeValues?.email?.S).toEqual(contextJSON.arguments.email);
  // expect(result.attributeValues?.addressLine1?.S).toEqual(contextJSON.arguments.addressLine1);
  // expect(result.attributeValues?.addressLine2?.S).toEqual(contextJSON.arguments.addressLine2);
})

test('APPSYNC-TEST 3: GetCongregationsById Resolver', async () => {
  const code = functionCodes.funcGetCongregationsByIdCode;

  const context = {
    "arguments": {
      "ids": ["2dfee7ad-d655-4d6d-86f7-f3ac142f3d19", "4064ec4e-18e6-4410-83a1-54865e12f6f8"],
      "limit": 20
    },
  };

  const input: EvaluateCodeCommandInput = {
    runtime: runtime,
    code: code,
    context: JSON.stringify(context),
    function: 'request',
  };

  const evaluateCodeCommand = new EvaluateCodeCommand(input);

  // Act
  const response = await client.send(evaluateCodeCommand);

  //Assert
  // Ensure that evaluationResult is a valid JSON string
  expect(response).toBeDefined();
  expect(response.error).toBeUndefined();
  expect(response.evaluationResult).toBeDefined();

  const result = JSON.parse(response.evaluationResult ?? '{}');

  // Object.prototype.toString = function(){
  //   return JSON.stringify(this)
  // }

  // console.log("result: " + result.toString());

  // console.log(result[0].toString());

  expect(result.length).toEqual(2);

  expect(result[0].operation).toEqual('GetItem');
  expect(result[0].key?.id?.S).toBeDefined();
  expect(result[0].key?.id?.S).toEqual(context.arguments.ids[0]);

  expect(result[1].operation).toEqual('GetItem');
  expect(result[1].key?.id?.S).toBeDefined();
  expect(result[1].key?.id?.S).toEqual(context.arguments.ids[1]);
})