import { join } from 'path';
import { readFileSync, writeFileSync, readdirSync } from 'fs';
import { makeExecutableSchema } from '@graphql-tools/schema';
import { gql } from 'graphql-tag';
import { printSchema } from 'graphql';

export default function SchemaGenerator() {
  const schemaPath = __dirname + "/../schemaFiles/";
  const outputFile = __dirname + "/../schema.generated.graphql";

  // console.log("Schema Path: " + schemaPath);
  // console.log("Schema Output File: " + outputFile);

  // Read all files from the schema directory and filter for .graphql files
  const schemaFiles = readdirSync(schemaPath)
    .filter(file => file.endsWith('.graphql'));
  
  let typeDefs = '';

  schemaFiles.forEach(file => {
    const filePath = join(schemaPath, file);
    const contents = readFileSync(filePath, 'utf-8');
    typeDefs += contents + '\n';
  });
  
  const schema = makeExecutableSchema({ typeDefs: gql`${typeDefs}` });
  
  // Use graphql.printSchema to print the schema
  const printedSchema = printSchema(schema);
  
  writeFileSync(outputFile, printedSchema); // Output file
}