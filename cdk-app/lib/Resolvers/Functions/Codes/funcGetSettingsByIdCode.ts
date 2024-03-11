
const funcGetSettingsByIdCode = `import * as ddb from '@aws-appsync/utils/dynamodb';

export function request(ctx) {
    return ddb.get({ key: { id: ctx.args.id } });
}

export function response(ctx) {
    var resultArray = [];
    
    resultArray[0] = {id: ctx.result.id, settings: ctx.result.settings};
    resultArray[1] = {id: ctx.stash.systemSettings.id, settings: ctx.stash.systemSettings.settings};
    
    return resultArray;
}
`;

export default funcGetSettingsByIdCode;