const funcAddBranchCode = `import { util } from '@aws-appsync/utils'
import * as ddb from '@aws-appsync/utils/dynamodb'

export function request(ctx) {
  const {id, ...item} = ctx.arguments.input;
  const key = { id: ctx.args.id ?? util.autoId() }
	return ddb.put({ key, item })
}

export function response(ctx) {
  return ctx.result;
}`;

export default funcAddBranchCode;