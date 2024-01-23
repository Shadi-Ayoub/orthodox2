const funcAddCongregationCode = `import { runtime, util } from '@aws-appsync/utils'
export function request(ctx) {
  // runtime.earlyReturn({ id: ctx.args.input.nameEnglish })
  // const date = Date.now().toString();
  return {
    operation: 'PutItem',
    key: util.dynamodb.toMapValues({id: util.autoId()}),
    attributeValues: util.dynamodb.toMapValues(ctx.args.input),
  };
}

export function response(ctx) {
  return ctx.result;
}`;

export default funcAddCongregationCode;