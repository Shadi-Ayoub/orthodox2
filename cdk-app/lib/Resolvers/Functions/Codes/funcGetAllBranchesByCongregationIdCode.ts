
const funcGetAllBranchesByCongregationId = `import * as ddb from '@aws-appsync/utils/dynamodb';

export function request(ctx) {
    const { limit = 20, nextToken, congregationId } = ctx.arguments;
    return ddb.query({
        index: 'congregation-index',
        query: { congregationId: { eq: congregationId } },
        limit,
        nextToken,
    });
}
  
export function response(ctx) {
    const { items: branches = [], nextToken } = ctx.result;
    return { branches, nextToken };
}`;

export default funcGetAllBranchesByCongregationId;