require('dotenv').config({path : __dirname + '/../../.env'});

const funcUpdateSettingsCode = `import { util } from '@aws-appsync/utils';

export function request(ctx) {
  const settingsArray = ctx.args.settings.map((setting) => JSON.parse(setting));

  return {
    operation: "BatchPutItem",
    tables: {
      ${process.env.DYNAMODB_TABLE_NAME_SETTINGS}: settingsArray.map((setting) => util.dynamodb.toMapValues(setting)),
    },
  };
}

export function response(ctx) {
  const { error, result } = ctx;
  if (error) {
    util.appendError(error.message, error.type);
  }
  return ctx.result.data.${process.env.DYNAMODB_TABLE_NAME_SETTINGS};
}
`;

export default funcUpdateSettingsCode;


// import { runtime, util } from '@aws-appsync/utils';

// export function request(ctx) {
//     // return runtime.earlyReturn([ {id: 'xxx', settings: ctx.args.settings[0]} ]);
//     const settingsArray = ctx.args.settings.map((setting) => JSON.parse(setting));
    
//     return {
//         operation: "BatchPutItem",
//         tables: {
//             FaithHubSpotSettingTable: settingsArray.map((setting) =>
//                 util.dynamodb.toMapValues(setting)),
//         },
//     };
// }

// export function response(ctx) {
//   const { error, result } = ctx;
//   if (error) {
//     util.appendError(error.message, error.type);
//   }
//   return ctx.result.data.FaithHubSpotSettingTable;
// }