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
