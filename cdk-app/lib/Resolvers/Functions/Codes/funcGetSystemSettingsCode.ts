
const funcGetSystemSettingsCode = `import * as ddb from '@aws-appsync/utils/dynamodb';

export function request(ctx) {
    return ddb.get({ key: { id: "sys" } });
}

export function response(ctx) {
    ctx.stash.systemSettings = ctx.result;
    return {};
}
`;

export default funcGetSystemSettingsCode;