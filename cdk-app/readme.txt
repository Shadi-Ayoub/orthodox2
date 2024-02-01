* CDK sample commands:
    - cdk init app --language typescript
    - cdk ls
    - npm run build
    - cdk diff
    - cdk deploy
    
* To bootstrap AWS CDK:
    cdk bootstrap aws://732706519267/us-east-1

* Minimum IAM user permissions to bootstrap AWS CDK (https://github.com/aws/aws-cdk/issues/21937):
{
	"Version": "2012-10-17",
	"Statement": [
		{
			"Sid": "AppSyncAccess",
			"Effect": "Allow",
			"Action": [
				"appsync:CreateGraphqlApi",
				"appsync:UpdateGraphqlApi",
				"appsync:DeleteGraphqlApi",
				"appsync:CreateDataSource",
				"appsync:UpdateDataSource",
				"appsync:DeleteDataSource",
				"appsync:CreateResolver",
				"appsync:UpdateResolver",
				"appsync:DeleteResolver",
				"appsync:CreateFunction",
				"appsync:UpdateFunction",
				"appsync:DeleteFunction"
			],
			"Resource": "*"
		},
		{
			"Action": [
				"cloudformation:CreateChangeSet",
				"cloudformation:DeleteStack",
				"cloudformation:DescribeChangeSet",
				"cloudformation:DescribeStackEvents",
				"cloudformation:DescribeStacks",
				"cloudformation:ExecuteChangeSet",
				"cloudformation:GetTemplate"
			],
			"Resource": [
				"arn:aws:cloudformation:*:*:stack/CDKToolkit/*",
				"arn:aws:cloudformation:*:*:stack/CdkStack/*"
			],
			"Effect": "Allow",
			"Sid": "CloudFormationPermissions"
		},
		{
			"Action": [
				"iam:CreateRole",
				"iam:DeleteRole",
				"iam:GetRole",
				"iam:AttachRolePolicy",
				"iam:DetachRolePolicy",
				"iam:DeleteRolePolicy",
				"iam:PutRolePolicy",
				"iam:PassRole"
			],
			"Effect": "Allow",
			"Resource": [
				"arn:aws:iam::*:policy/*",
				"arn:aws:iam::*:role/cdk-*"
			]
		},
		{
			"Action": [
				"s3:CreateBucket",
				"s3:DeleteBucket",
				"s3:PutBucketPolicy",
				"s3:DeleteBucketPolicy",
				"s3:PutBucketPublicAccessBlock",
				"s3:PutBucketVersioning",
				"s3:PutEncryptionConfiguration",
				"s3:PutLifecycleConfiguration",
				"s3:GetObject",
				"s3:PutObject",
				"s3:ListBucket",
				"s3:GetBucketLocation"
			],
			"Effect": "Allow",
			"Resource": [
				"arn:aws:s3:::cdk-*"
			]
		},
		{
			"Action": [
				"ssm:DeleteParameter",
				"ssm:GetParameter",
				"ssm:GetParameters",
				"ssm:PutParameter"
			],
			"Effect": "Allow",
			"Resource": [
				"arn:aws:ssm:*:*:parameter/cdk-bootstrap/*"
			]
		},
		{
			"Action": [
				"ecr:CreateRepository",
				"ecr:DeleteRepository",
				"ecr:DescribeRepositories",
				"ecr:SetRepositoryPolicy",
				"ecr:PutLifecyclePolicy"
			],
			"Effect": "Allow",
			"Resource": [
				"arn:aws:ecr:*:*:repository/cdk-*"
			]
		}
	]
}

"arn:aws:iam::*:policy/*",
"arn:aws:iam::*:role/cdk-*",

mutation MyMutation2 {
  addCongregation(input: {code: "ORTHODOX-UAE2", nameEnglish: "Greek Orthodox Archbishopric in UAE", nameNative: "مطرانية الروم الأرثوذكس في الإمارات"}) {
    id
    code
    nameEnglish
    nameNative
  }
}

mutation MyMutation {
  addBranch(input: {city: "city1", congregationId: "2dfee7ad-d655-4d6d-86f7-f3ac142f3d19", country: "UAE", id: "", name: "branch1"}) {
    city
    congregationId
    id
    country
    name
  }
}

id	nameEnglish	code	nameNative
2dfee7ad-d655-4d6d-86f7-f3ac142f3d19	Greek Orthodox Archbishopric in UAE	ORTHODOX-UAE4	مطرانية الروم الأرثوذكس في الإمارات
4064ec4e-18e6-4410-83a1-54865e12f6f8	Greek Orthodox Archbishopric in UAE	ORTHODOX-UAE5	مطرانية الروم الأرثوذكس في الإمارات
3c49fa40-b4bb-422b-8dab-2c9c5a9fde6e	Greek Orthodox Archbishopric in UAE	ORTHODOX-UAE4	مطرانية الروم الأرثوذكس في الإمارات
ae23308a-f7f6-44c6-ac16-fcf242e0060e	Greek Orthodox Archbishopric in UAE	ORTHODOX-UAE2	مطرانية الروم الأرثوذكس في الإمارات
a4bdbb48-6bc6-44d9-8f62-624ffabde065	Greek Orthodox Archbishopric in UAE	ORTHODOX-UAE5	مطرانية الروم الأرثوذكس في الإمارات
bbacb8bb-3c49-4aa6-ba7d-2e2e880a4e5b	Greek Orthodox Archbishopric in UAE	ORTHODOX-UAE3	مطرانية الروم الأرثوذكس في الإمارات
421a9ef5-a822-4fd2-a5a3-7c7c6ff85db3	Greek Orthodox Archbishopric in UAE	ORTHODOX-UAE5	مطرانية الروم الأرثوذكس في الإمارات
b768fef9-0ae7-48d1-b575-02162a6cc01b	Greek Orthodox Archbishopric in UAE	ORTHODOX-UAE2	مطرانية الروم الأرثوذكس في الإمارات

return runtime.earlyReturn({ id: ctx.error.message })

mutation MyMutation {
  addBranch(input: {city: "city1", congregationId: "4064ec4e-18e6-4410-83a1-54865e12f6f8", country: "UAE", id: "", name: "branch1"}) {
    city
    congregationId
    id
    country
    name
  }
}

mutation MyMutation {
  addCongregation(input: {addressLine1: "Addrerss Line 1", addressLine2: "Address Line 2", city: "Dubai", contactNo1: "123456", contactNo2: "123456", country: "uae", email: "email@domain.com", nameEnglish: "Greek Orthodox Archbishopric in UAE", nameNative: "مطرانية الروم الأرثوذكس في الإمارات"}) {
    addressLine1
    addressLine2
    city
    contactNo1
    contactNo2
    country
    email
    id
    nameEnglish
    nameNative
  }
}


query MyQuery2 {
  getAllBranchesByCongregationId(congregationId: "4064ec4e-18e6-4410-83a1-54865e12f6f8", limit: 20) {
    nextToken
    branches {
      city
      congregationId
      country
      id
      name
    }
  }
}
