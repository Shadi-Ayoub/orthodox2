import * as ddb from '@aws-appsync/utils/dynamodb';

export function request(ctx) {
    return {};
}

export function response(ctx) {
    const codes = ctx.prev.result;
    
    const congregationsGroupedByCode = [];
    
    codes.forEach((code) => {
        const obj = {};
        obj.code = code;
        obj.congregations = ddb.query({
                                        index: 'id-code-index',
                                        query: { code: { eq: code } },
                                      });
        congregationsGroupedByCode.push(obj);
    });
    
    return congregationsGroupedByCode;
}
