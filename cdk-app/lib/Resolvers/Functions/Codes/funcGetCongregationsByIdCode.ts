
const funcGetCongregationsByIdCode = `import * as ddb from '@aws-appsync/utils/dynamodb';

export function request(ctx) {
    const { ids } = ctx.args;

    var congregations = [];
    var cong;

    ids.forEach(id => {
        cong = ddb.get({ key: { id: id } });
        congregations.push(cong);
    });

    return congregations;
}

export function response(ctx) {
    return ctx.result.items;
}`;

export default funcGetCongregationsByIdCode;