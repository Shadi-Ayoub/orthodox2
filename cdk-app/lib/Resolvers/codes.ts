export const resolverRequestCode1 = `export function request(ctx) {
    return {};
}

`;

export const resolverResponseCode1 = `export function response(ctx) {
    return ctx.prev.result;
}`;