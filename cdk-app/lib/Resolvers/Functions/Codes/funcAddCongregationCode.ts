const funcAddCongregationCode = `import { runtime, util } from '@aws-appsync/utils'
import * as ddb from '@aws-appsync/utils/dynamodb'

export function request(ctx) {
  // return runtime.earlyReturn({ id: ctx.error.message })
  // const date = Date.now().toString();
  const item = { ...ctx.arguments.input }
	const key = { id: ctx.args.id ?? util.autoId() }
	return ddb.put({ key, item })
}

export function response(ctx) {
  return ctx.result;
}`;

export default funcAddCongregationCode;