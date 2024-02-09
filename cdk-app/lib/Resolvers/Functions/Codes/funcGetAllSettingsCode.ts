
const funcGetAllSettingsCode = `export function request(ctx) {
    return { operation: 'Scan' };
}

export function response(ctx) {
    return ctx.result.items;
}`;

export default funcGetAllSettingsCode;