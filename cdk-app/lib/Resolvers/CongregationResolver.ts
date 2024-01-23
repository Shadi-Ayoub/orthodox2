//Create the Congregations Resolver
import * as appsync from 'aws-cdk-lib/aws-appsync';

import {IResolver} from './ResolverTypes'
import funcGetCongregationsCode from './Functions/Congregation/Codes/funcGetCongregationsCode'
import funcAddCongregationCode from './Functions/Congregation/Codes/funcAddCongregationCode'

// pass the dataSource as {Congregation: congregationsDataSource} from the caller
export default function createCongregationsResolver(input: IResolver) {
    // Creates a function for query
    const funcGetCongregations = new appsync.AppsyncFunction(input.scope, 'funcGetCongregations', {
      name: 'funcGetCongregations',
      api: input.api,
      dataSource: input.dataSource["Congregation"],
      code: appsync.Code.fromInline(funcGetCongregationsCode),
      runtime: appsync.FunctionRuntime.JS_1_0_0,
    });

    // Creates a function for mutation
    const funcAddCongregation = new appsync.AppsyncFunction(input.scope, 'funcAddCongregation', {
      name: 'funcAddCongregation',
      api: input.api,
      dataSource: input.dataSource["Congregation"],
      code: appsync.Code.fromInline(funcAddCongregationCode),
      runtime: appsync.FunctionRuntime.JS_1_0_0,
    });

    // Adds a pipeline resolver with the get function
    new appsync.Resolver(input.scope, 'pipelineResolverGetCongregations', {
      api: input.api,
      typeName: 'Query',
      fieldName: 'getAllCongregations',
      code: appsync.Code.fromInline(
        `export function request(ctx) {
          return {};
        }

        export function response(ctx) {
          return ctx.prev.result;
        }`
      ),
      runtime: appsync.FunctionRuntime.JS_1_0_0,
      pipelineConfig: [funcGetCongregations],
    });

    // Adds a pipeline resolver with the add function
    new appsync.Resolver(input.scope, 'pipelineResolverAddCongregation', {
      api: input.api,
      typeName: 'Mutation',
      fieldName: 'addCongregation',
      code: appsync.Code.fromInline(
        `export function request(ctx) {
          return {};
        }

        export function response(ctx) {
          return ctx.prev.result;
        }`
      ),
      runtime: appsync.FunctionRuntime.JS_1_0_0,
      pipelineConfig: [funcAddCongregation],
    });
  }