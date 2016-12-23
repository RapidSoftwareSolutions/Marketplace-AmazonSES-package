# AmazonSES Package
Amazon SES is an email platform that provides an easy, cost-effective way for you to send and receive email using your own email addresses and domains.
* Domain: amazon.com
* Credentials: apiKey, apiSecret

## How to get credentials: 
0. Go to [Amazon Console](https://console.aws.amazon.com/console/home?region=us-east-1)
1. Log in or create new account
2. Create new group in Groups section at the left side with necessary polices
3. Create new user and assign to existing group
4. After creating user you will see credentials
 
## AmazonSES.createConfigurationSet
Creates a configuration set.

| Field            | Type       | Description
|------------------|------------|----------
| apiKey           | credentials| API key obtained from Amazon.
| apiSecret        | credentials| API secret obtained from Amazon.
| region           | String     | Region.
| configurationName| String     | The name of the configuration set. The name must: Contain only ASCII letters (a-z, A-Z), numbers (0-9), underscores (_), or dashes (-). Contain less than 64 characters.

## AmazonSES.createConfigurationSetEventDestination
Creates a configuration set event destination. An event destination is the AWS service to which Amazon SES publishes the email sending events associated with a configuration set.

| Field                | Type       | Description
|----------------------|------------|----------
| apiKey               | credentials| API key obtained from Amazon.
| apiSecret            | credentials| API secret obtained from Amazon.
| region               | String     | Region.
| configurationName    | String     | The name of the configuration set to which to apply the event destination.
| destinationName      | String     | The name of the event destination. The name must: Contain only ASCII letters (a-z, A-Z), numbers (0-9), underscores (_), or dashes (-). Contain less than 64 characters.
| matchingEventTypes   | JSON       | Array of strings. The type of email sending events to publish to the event destination. Valid Values: send; reject; bounce; complaint; delivery
| enabled              | String     | Sets whether Amazon SES publishes events to this destination when you send an email with the associated configuration set. Set to true to enable publishing to this destination; set to false to prevent publishing to this destination. The default value is false.
| cloudWatchDestination| JSON       | An object that contains the names, default values, and sources of the dimensions associated with an Amazon CloudWatch event destination. See README for more details.
| deliveryStreamARN    | String     | The ARN of the Amazon Kinesis Firehose stream to which to publish email sending events.
| IAMRoleARN           | String     | The ARN of the IAM role under which Amazon SES publishes email sending events to the Amazon Kinesis Firehose stream.

#### matchingEventTypes format
```json
["send"]
```
#### cloudWatchDestination format
```json


{  
    "DimensionConfigurations":[  
        {  
            "DimensionName":"NewDimension",
            "DimensionValueSource":"messageTag",
            "DefaultDimensionValue":"test"
        }
    ]
}
```
## AmazonSES.createReceiptFilter
Creates a new IP address filter.

| Field    | Type       | Description
|----------|------------|----------
| apiKey   | credentials| API key obtained from Amazon.
| apiSecret| credentials| API secret obtained from Amazon.
| region   | String     | Region.
| name     | String     | The name of the IP address filter. The name must: Contain only ASCII letters (a-z, A-Z), numbers (0-9), periods (.), underscores (_), or dashes (-). Start and end with a letter or number. Contain less than 64 characters.
| CIDR     | String     | A single IP address or a range of IP addresses that you want to block or allow, specified in Classless Inter-Domain Routing (CIDR) notation. An example of a single email address is 10.0.0.1. An example of a range of IP addresses is 10.0.0.1/24. For more information about CIDR notation, see RFC 2317.
| policy   | String     | Indicates whether to block or allow incoming mail from the specified IP addresses. Valid Values: Block; Allow

## AmazonSES.createReceiptRuleSet
Creates an empty receipt rule set.

| Field      | Type       | Description
|------------|------------|----------
| apiKey     | credentials| API key obtained from Amazon.
| apiSecret  | credentials| API secret obtained from Amazon.
| region     | String     | Region.
| ruleSetName| String     | The name of the rule set to create. The name must: Contain only ASCII letters (a-z, A-Z), numbers (0-9), periods (.), underscores (_), or dashes (-). Start and end with a letter or number. Contain less than 64 characters.

## AmazonSES.cloneReceiptRuleSet
Creates a receipt rule set by cloning an existing one. All receipt rules and configurations are copied to the new receipt rule set and are completely independent of the source rule set.

| Field              | Type       | Description
|--------------------|------------|----------
| apiKey             | credentials| API key obtained from Amazon.
| apiSecret          | credentials| API secret obtained from Amazon.
| region             | String     | Region.
| originalRuleSetName| String     | The name of the rule set to clone.
| ruleSetName        | String     | The name of the rule set to create. The name must: Contain only ASCII letters (a-z, A-Z), numbers (0-9), periods (.), underscores (_), or dashes (-). Start and end with a letter or number. Contain less than 64 characters.

## AmazonSES.createReceiptRule
Creates a receipt rule.

| Field      | Type       | Description
|------------|------------|----------
| apiKey     | credentials| API key obtained from Amazon.
| apiSecret  | credentials| API secret obtained from Amazon.
| region     | String     | Region.
| ruleSetName| String     | The name of the rule set to which to add the rule.
| ruleName   | String     | The name of the receipt rule. The name must: Contain only ASCII letters (a-z, A-Z), numbers (0-9), periods (.), underscores (_), or dashes (-). Start and end with a letter or number. Contain less than 64 characters.
| after      | String     | The name of an existing rule after which the new rule will be placed. If this parameter is null, the new rule will be inserted at the beginning of the rule list.
| actions    | JSON       | An ordered list of actions to perform on messages that match at least one of the recipient email addresses or domains specified in the receipt rule. See README for more details.
| enabled    | String     | If true, the receipt rule is active. The default value is false.
| scanEnabled| String     | If true, then messages to which this receipt rule applies are scanned for spam and viruses. The default value is false.
| tlsPolicy  | String     | Specifies whether Amazon SES should require that incoming email is delivered over a connection encrypted with Transport Layer Security (TLS). If this parameter is set to Require, Amazon SES will bounce emails that are not received over TLS. The default is Optional. Valid Values: Require; Optional
| recipients | JSON       | Array of strings. The recipient domains and email addresses to which the receipt rule applies. If this field is not specified, this rule will match all recipients under all verified domains.

#### actions format
```json
[
    {
      "S3Action": {
        "TopicArn": "string",
        "BucketName": "string",
        "ObjectKeyPrefix": "string",
        "KmsKeyArn": "string"
      },
      "BounceAction": {
        "TopicArn": "string",
        "SmtpReplyCode": "string",
        "StatusCode": "string",
        "Message": "string",
        "Sender": "string"
      },
      "WorkmailAction": {
        "TopicArn": "string",
        "OrganizationArn": "string"
      },
      "LambdaAction": {
        "TopicArn": "string",
        "FunctionArn": "string",
        "InvocationType": "Event"|"RequestResponse"
      },
      "StopAction": {
        "Scope": "RuleSet",
        "TopicArn": "string"
      },
      "AddHeaderAction": {
        "HeaderName": "string",
        "HeaderValue": "string"
      },
      "SNSAction": {
        "TopicArn": "string",
        "Encoding": "UTF-8"|"Base64"
      }
    }
    ...
  ]
```
#### recipients format
```json
["string", ...]
```
## AmazonSES.describeActiveReceiptRuleSet
Returns the metadata and receipt rules for the receipt rule set that is currently active.

| Field    | Type       | Description
|----------|------------|----------
| apiKey   | credentials| API key obtained from Amazon.
| apiSecret| credentials| API secret obtained from Amazon.
| region   | String     | Region.

## AmazonSES.describeConfigurationSet
Returns the details of the specified configuration set.

| Field               | Type       | Description
|---------------------|------------|----------
| apiKey              | credentials| API key obtained from Amazon.
| apiSecret           | credentials| API secret obtained from Amazon.
| region              | String     | Region.
| configurationSetName| String     | The name of the configuration set to describe.
| attributeNames      | JSON       | Array os strings. A list of configuration set attributes to return. Valid Values: eventDestinations

#### attributeNames format
```json
["eventDestinations"]
```
## AmazonSES.describeReceiptRule
Returns the details of the specified receipt rule.

| Field      | Type       | Description
|------------|------------|----------
| apiKey     | credentials| API key obtained from Amazon.
| apiSecret  | credentials| API secret obtained from Amazon.
| region     | String     | Region.
| ruleName   | String     | The name of the receipt rule.
| ruleSetName| String     | The name of the receipt rule set to which the receipt rule belongs.

## AmazonSES.describeReceiptRuleSet
Returns the details of the specified receipt rule set.

| Field      | Type       | Description
|------------|------------|----------
| apiKey     | credentials| API key obtained from Amazon.
| apiSecret  | credentials| API secret obtained from Amazon.
| region     | String     | Region.
| ruleSetName| String     | The name of the receipt rule set to describe.

## AmazonSES.getIdentityDkimAttributes
Returns the current status of Easy DKIM signing for an entity. For domain name identities, this action also returns the DKIM tokens that are required for Easy DKIM signing, and whether Amazon SES has successfully verified that these tokens have been published.

| Field     | Type       | Description
|-----------|------------|----------
| apiKey    | credentials| API key obtained from Amazon.
| apiSecret | credentials| API secret obtained from Amazon.
| region    | String     | Region.
| identities| JSON       | Array of strings. A list of one or more verified identities - email addresses, domains, or both.

#### identities format
```json
["test@test.com"]
```
## AmazonSES.getIdentityMailFromDomainAttributes
Returns the custom MAIL FROM attributes for a list of identities (email addresses and/or domains).

| Field     | Type       | Description
|-----------|------------|----------
| apiKey    | credentials| API key obtained from Amazon.
| apiSecret | credentials| API secret obtained from Amazon.
| region    | String     | Region.
| identities| JSON       | Array of strings. A list of one or more identities.

#### identities format
```json
["test@test.com"]
```
## AmazonSES.getIdentityNotificationAttributes
Given a list of verified identities (email addresses and/or domains), returns a structure describing identity notification attributes.

| Field     | Type       | Description
|-----------|------------|----------
| apiKey    | credentials| API key obtained from Amazon.
| apiSecret | credentials| API secret obtained from Amazon.
| region    | String     | Region.
| identities| JSON       | Array of strings. A list of one or more identities. You can specify an identity by using its name or by using its Amazon Resource Name (ARN). Examples: user@example.com, example.com, arn:aws:ses:us-east-1:123456789012:identity/example.com.

#### identities format
```json
["test@test.com"]
```
## AmazonSES.getIdentityPolicies
Returns the requested sending authorization policies for the given identity (an email address or a domain). The policies are returned as a map of policy names to policy contents. You can retrieve a maximum of 20 policies at a time.

| Field      | Type       | Description
|------------|------------|----------
| apiKey     | credentials| API key obtained from Amazon.
| apiSecret  | credentials| API secret obtained from Amazon.
| region     | String     | Region.
| identity   | String     | The identity for which the policies will be retrieved. You can specify an identity by using its name or by using its Amazon Resource Name (ARN). Examples: user@example.com, example.com, arn:aws:ses:us-east-1:123456789012:identity/example.com.
| policyNames| JSON       | Array of strings. A list of the names of policies to be retrieved. You can retrieve a maximum of 20 policies at a time. If you do not know the names of the policies that are attached to the identity, you can use ListIdentityPolicies.

#### policyNames format
```json
["ListIdentityPolicies"]
```
## AmazonSES.getIdentityVerificationAttributes
Given a list of identities (email addresses and/or domains), returns the verification status and (for domain identities) the verification token for each identity.

| Field     | Type       | Description
|-----------|------------|----------
| apiKey    | credentials| API key obtained from Amazon.
| apiSecret | credentials| API secret obtained from Amazon.
| region    | String     | Region.
| identities| JSON       | Array of strings. A list of identities. For more details see README.

#### identities format
```json
["test@test.com"]
```
## AmazonSES.getSendQuota
Returns the user's current sending limits.

| Field    | Type       | Description
|----------|------------|----------
| apiKey   | credentials| API key obtained from Amazon.
| apiSecret| credentials| API secret obtained from Amazon.
| region   | String     | Region.

## AmazonSES.getSendStatistics
Returns the user's sending statistics. The result is a list of data points, representing the last two weeks of sending activity. Each data point in the list contains statistics for a 15-minute interval.

| Field    | Type       | Description
|----------|------------|----------
| apiKey   | credentials| API key obtained from Amazon.
| apiSecret| credentials| API secret obtained from Amazon.
| region   | String     | Region.

## AmazonSES.listConfigurationSets
Lists the configuration sets associated with your AWS account.

| Field    | Type       | Description
|----------|------------|----------
| apiKey   | credentials| API key obtained from Amazon.
| apiSecret| credentials| API secret obtained from Amazon.
| region   | String     | Region.
| maxItems | String     | The number of configuration sets to return.
| nextToken| String     | A token returned from a previous call to ListConfigurationSets to indicate the position of the configuration set in the configuration set list.

## AmazonSES.listIdentities
Returns a list containing all of the identities (email addresses and domains) for your AWS account, regardless of verification status.

| Field       | Type       | Description
|-------------|------------|----------
| apiKey      | credentials| API key obtained from Amazon.
| apiSecret   | credentials| API secret obtained from Amazon.
| region      | String     | Region.
| identityType| String     | The type of the identities to list. Possible values are "EmailAddress" and "Domain". If this parameter is omitted, then all identities will be listed. Valid Values: EmailAddress; Domain
| maxItems    | String     | The number of configuration sets to return.
| nextToken   | String     | A token returned from a previous call to ListConfigurationSets to indicate the position of the configuration set in the configuration set list.

## AmazonSES.listIdentityPolicies
Returns a list of sending authorization policies that are attached to the given identity (an email address or a domain). 

| Field    | Type       | Description
|----------|------------|----------
| apiKey   | credentials| API key obtained from Amazon.
| apiSecret| credentials| API secret obtained from Amazon.
| region   | String     | Region.
| identity | String     | The identity that is associated with the policy for which the policies will be listed. You can specify an identity by using its name or by using its Amazon Resource Name (ARN). Examples: user@example.com, example.com, arn:aws:ses:us-east-1:123456789012:identity/example.com.

## AmazonSES.listReceiptFilters
Lists the IP address filters associated with your AWS account.

| Field    | Type       | Description
|----------|------------|----------
| apiKey   | credentials| API key obtained from Amazon.
| apiSecret| credentials| API secret obtained from Amazon.
| region   | String     | Region.

## AmazonSES.listReceiptRuleSets
Lists the receipt rule sets that exist under your AWS account. If there are additional receipt rule sets to be retrieved, you will receive a NextToken that you can provide to the next call to ListReceiptRuleSets to retrieve the additional entries.

| Field    | Type       | Description
|----------|------------|----------
| apiKey   | credentials| API key obtained from Amazon.
| apiSecret| credentials| API secret obtained from Amazon.
| region   | String     | Region.
| NextToken| String     | A token returned from a previous call to ListReceiptRuleSets to indicate the position in the receipt rule set list.

## AmazonSES.putIdentityPolicy
Adds or updates a sending authorization policy for the specified identity (an email address or a domain).

| Field     | Type       | Description
|-----------|------------|----------
| apiKey    | credentials| API key obtained from Amazon.
| apiSecret | credentials| API secret obtained from Amazon.
| region    | String     | Region.
| identity  | String     | The identity to which the policy will apply. You can specify an identity by using its name or by using its Amazon Resource Name (ARN). Examples: user@example.com, example.com, arn:aws:ses:us-east-1:123456789012:identity/example.com.
| policy    | JSON       | The text of the policy in JSON format. The policy cannot exceed 4 KB. See README for more details.
| policyName| String     | The name of the policy.

#### policy format
```json
 {
  "Id": "SampleAuthorizationPolicy",	
  "Version": "2012-10-17",
  "Statement": [
    {
      "Sid": "ControlAction",
      "Effect": "Allow",
      "Resource": "arn:aws:ses:eu-west-1:828310069595:identity/test@test.com",
      "Principal": {"AWS": ["828310069590"]},
      "Action": ["SES:SendRawEmail"]
    }
  ]
}
```

## AmazonSES.reorderReceiptRuleSet
Reorders the receipt rules within a receipt rule set.

| Field      | Type       | Description
|------------|------------|----------
| apiKey     | credentials| API key obtained from Amazon.
| apiSecret  | credentials| API secret obtained from Amazon.
| region     | String     | Region.
| ruleNames  | JSON       | Array of strings. A list of the specified receipt rule set's receipt rules in the order that you want to put them. See README for more details.
| ruleSetName| String     | The name of the receipt rule set to reorder.

#### ruleNames format
```json
["RuleName"]
```
## AmazonSES.sendBounce
Generates and sends a bounce message to the sender of an email you received through Amazon SES. You can only use this API on an email up to 24 hours after you receive it.

| Field                   | Type       | Description
|-------------------------|------------|----------
| apiKey                  | credentials| API key obtained from Amazon.
| apiSecret               | credentials| API secret obtained from Amazon.
| region                  | String     | Region.
| bounceSender            | String     | The address to use in the "From" header of the bounce message. This must be an identity that you have verified with Amazon SES.
| originalMessageId       | String     | The message ID of the message to be bounced.
| bouncedRecipientInfoList| JSON       | A list of recipients of the bounced message, including the information required to create the Delivery Status Notifications (DSNs) for the recipients. You must specify at least one BouncedRecipientInfo in the list. See README for more details.
| bounceSenderArn         | String     | This parameter is used only for sending authorization. It is the ARN of the identity that is associated with the sending authorization policy that permits you to use the address in the "From" header of the bounce. 
| explanation             | String     | Human-readable text for the bounce message to explain the failure. If not specified, the text will be auto-generated based on the bounced recipient information.
| messageDsn              | JSON       | Message-related DSN fields. If not specified, Amazon SES will choose the values. See README for more details.

#### bouncedRecipientInfoList format
```json
[
    {
        "Recipient": "test@test.com"
    }
]
```
#### messageDsn format
```json
{
  "ReportingMta": "string",
  "ArrivalDate": timestamp,
  "ExtensionFields": [
    {
      "Name": "string",
      "Value": "string"
    }
    ...
  ]
}
```
## AmazonSES.sendEmail
Composes an email message based on input data, and then immediately queues the message for sending.

| Field               | Type       | Description
|---------------------|------------|----------
| apiKey              | credentials| API key obtained from Amazon.
| apiSecret           | credentials| API secret obtained from Amazon.
| region              | String     | Region.
| destination         | JSON       | The destination for this email, composed of To:, CC:, and BCC: fields. See README for more details.
| message             | JSON       | The message to be sent. See README for more details.
| fromEmail           | String     | The email address that is sending the email. This email address must be either individually verified with Amazon SES, or from a domain that has been verified with Amazon SES.
| configurationSetName| String     | The name of the configuration set to use when you send an email using SendEmail.
| replyToAddresses    | JSON       | Array of strings. The reply-to email address(es) for the message. If the recipient replies to the message, each reply-to address will receive the reply. See README for more details.
| returnPath          | String     | The email address to which bounces and complaints are to be forwarded when feedback forwarding is enabled.
| returnPathArn       | String     | This parameter is used only for sending authorization. It is the ARN of the identity that is associated with the sending authorization policy that permits you to use the email address specified in the ReturnPath parameter.
| sourceArn           | String     | This parameter is used only for sending authorization. It is the ARN of the identity that is associated with the sending authorization policy that permits you to send for the email address specified in the Source parameter. For example, if the owner of example.com (which has ARN arn:aws:ses:us-east-1:123456789012:identity/example.com) attaches a policy to it that authorizes you to send from user@example.com, then you would specify the SourceArn to be arn:aws:ses:us-east-1:123456789012:identity/example.com, and the Source to be user@example.com.
| tags                | JSON       | A list of tags, in the form of name/value pairs, to apply to an email that you send using SendEmail. Tags correspond to characteristics of the email that you define, so that you can publish email sending events. See README for more details.

#### destination format
```json
{
  "ToAddresses": ["string", ...],
  "CcAddresses": ["string", ...],
  "BccAddresses": ["string", ...]
}
```
#### message format
```json
{
  "Subject": {
    "Data": "string",
    "Charset": "string"
  },
  "Body": {
    "Text": {
      "Data": "string",
      "Charset": "string"
    },
    "Html": {
      "Data": "string",
      "Charset": "string"
    }
  }
}
```
#### replyToAddresses format
```json
["test@test.com"]
```
#### tags format
```json
[
  {
    "Name": "string",
    "Value": "string"
  }
  ...
]
```
## AmazonSES.sendPlainEmail
Composes an email plain message based on input data, and then immediately queues the message for sending.

| Field    | Type       | Description
|----------|------------|----------
| apiKey   | credentials| API key obtained from Amazon.
| apiSecret| credentials| API secret obtained from Amazon.
| region   | String     | Region.
| toEmail  | String     | The destination for this email.
| subject  | String     | The subject of the email.
| message  | String     | The message of the email.
| fromEmail| String     | The email address that is sending the email. This email address must be either individually verified with Amazon SES, or from a domain that has been verified with Amazon SES.

## AmazonSES.sendRawEmail
Sends an email message, with header and content specified by the client. The SendRawEmail action is useful for sending multipart MIME emails. The raw text of the message must comply with Internet email standards; otherwise, the message cannot be sent.

| Field               | Type       | Description
|---------------------|------------|----------
| apiKey              | credentials| API key obtained from Amazon.
| apiSecret           | credentials| API secret obtained from Amazon.
| region              | String     | Region.
| rawMessage          | JSON       | The raw text of the message. See README for more details.
| configurationSetName| String     | The name of the configuration set to use when you send an email using SendRawEmail.
| destinations        | JSON       | A list of destinations for the message, consisting of To:, CC:, and BCC: addresses. See README for more details.
| fromArn             | String     | This parameter is used only for sending authorization. It is the ARN of the identity that is associated with the sending authorization policy that permits you to specify a particular "From" address in the header of the raw email.
| returnPathArn       | String     | This parameter is used only for sending authorization. It is the ARN of the identity that is associated with the sending authorization policy that permits you to use the email address specified in the ReturnPath parameter. For example, if the owner of example.com (which has ARN arn:aws:ses:us-east-1:123456789012:identity/example.com) attaches a policy to it that authorizes you to use feedback@example.com, then you would specify the ReturnPathArn to be arn:aws:ses:us-east-1:123456789012:identity/example.com, and the ReturnPath to be feedback@example.com.
| source              | String     | The identity's email address. If you do not provide a value for this parameter, you must specify a "From" address in the raw text of the message. (You can also specify both.)
| sourceArn           | String     | This parameter is used only for sending authorization. It is the ARN of the identity that is associated with the sending authorization policy that permits you to send for the email address specified in the Source parameter. For example, if the owner of example.com (which has ARN arn:aws:ses:us-east-1:123456789012:identity/example.com) attaches a policy to it that authorizes you to send from user@example.com, then you would specify the SourceArn to be arn:aws:ses:us-east-1:123456789012:identity/example.com, and the Source to be user@example.com.
| tags                | JSON       | A list of tags, in the form of name/value pairs, to apply to an email that you send using SendRawEmail. Tags correspond to characteristics of the email that you define, so that you can publish email sending events. See README for more details.
#### rawMessage format
```json
{
   "Data": "From: test@test.com\nTo: to_email@test.com\nSubject: Test email sent using the AWS CLI (contains an attachment)\nMIME-Version: 1.0\nContent-type: Multipart/Mixed; boundary=\"NextPart\"\n\n--NextPart\nContent-Type: text/plain\n\nThis is the message body.\n\n--NextPart\nContent-Type: text/plain;\nContent-Disposition: attachment; filename=\"attachment.txt\"\n\nThis is the text in the attachment.\n\n--NextPart--"
}
```
#### destinations format
```json
["test@test.com"]
```
#### tags format
```json
[
  {
    "Name": "string",
    "Value": "string"
  }
  ...
]
```

## AmazonSES.setActiveReceiptRuleSet
Sets the specified receipt rule set as the active receipt rule set.

| Field      | Type       | Description
|------------|------------|----------
| apiKey     | credentials| API key obtained from Amazon.
| apiSecret  | credentials| API secret obtained from Amazon.
| region     | String     | Region.
| ruleSetName| String     | The name of the receipt rule set to make active. Setting this value to null disables all email receiving.

## AmazonSES.setIdentityDkimEnabled
Enables or disables Easy DKIM signing of email

| Field      | Type       | Description
|------------|------------|----------
| apiKey     | credentials| API key obtained from Amazon.
| apiSecret  | credentials| API secret obtained from Amazon.
| region     | String     | Region.
| dkimEnabled| String     | Sets whether DKIM signing is enabled for an identity. Set to true to enable DKIM signing for this identity; false to disable it.
| identity   | String     | The identity for which DKIM signing should be enabled or disabled.

## AmazonSES.setIdentityFeedbackForwardingEnabled
Given an identity (an email address or a domain), enables or disables whether Amazon SES forwards bounce and complaint notifications as email. Feedback forwarding can only be disabled when Amazon Simple Notification Service (Amazon SNS) topics are specified for both bounces and complaints.

| Field            | Type       | Description
|------------------|------------|----------
| apiKey           | credentials| API key obtained from Amazon.
| apiSecret        | credentials| API secret obtained from Amazon.
| region           | String     | Region.
| forwardingEnabled| String     | Sets whether DKIM signing is enabled for an identity. Set to true to enable DKIM signing for this identity; false to disable it.
| identity         | String     | The identity for which to set bounce and complaint notification forwarding. Examples: user@example.com, example.com.

## AmazonSES.setIdentityHeadersInNotificationsEnabled
Given an identity (an email address or a domain), sets whether Amazon SES includes the original email headers in the Amazon Simple Notification Service (Amazon SNS) notifications of a specified type.

| Field           | Type       | Description
|-----------------|------------|----------
| apiKey          | credentials| API key obtained from Amazon.
| apiSecret       | credentials| API secret obtained from Amazon.
| region          | String     | Region.
| enabled         | String     | Sets whether Amazon SES includes the original email headers in Amazon SNS notifications of the specified notification type. A value of true specifies that Amazon SES will include headers in notifications, and a value of false specifies that Amazon SES will not include headers in notifications.
| identity        | String     | The identity for which to enable or disable headers in notifications. Examples: user@example.com, example.com.
| notificationType| String     | The notification type for which to enable or disable headers in notifications. Valid Values: Bounce; Complaint; Delivery

## AmazonSES.setIdentityMailFromDomain
Enables or disables the custom MAIL FROM domain setup for a verified identity (an email address or a domain).

| Field              | Type       | Description
|--------------------|------------|----------
| apiKey             | credentials| API key obtained from Amazon.
| apiSecret          | credentials| API secret obtained from Amazon.
| region             | String     | Region.
| identity           | String     | The verified identity for which you want to enable or disable the specified custom MAIL FROM domain.
| BehaviorOnMXFailure| String     | The action that you want Amazon SES to take if it cannot successfully read the required MX record when you send an email. If you choose UseDefaultValue, Amazon SES will use amazonses.com (or a subdomain of that) as the MAIL FROM domain. If you choose RejectMessage, Amazon SES will return a MailFromDomainNotVerified error and not send the email. Valid Values: UseDefaultValue; RejectMessage.
| MailFromDomain     | String     | The custom MAIL FROM domain that you want the verified identity to use. The MAIL FROM domain must 1) be a subdomain of the verified identity, 2) not be used in a "From" address if the MAIL FROM domain is the destination of email feedback forwarding (for more information, see the Amazon SES Developer Guide), and 3) not be used to receive emails. A value of null disables the custom MAIL FROM setting for the identity.

## AmazonSES.setIdentityNotificationTopic
Given an identity (an email address or a domain), sets the Amazon Simple Notification Service (Amazon SNS) topic to which Amazon SES will publish bounce, complaint, and/or delivery notifications for emails sent with that identity as the Source.

| Field           | Type       | Description
|-----------------|------------|----------
| apiKey          | credentials| API key obtained from Amazon.
| apiSecret       | credentials| API secret obtained from Amazon.
| region          | String     | Region.
| identity        | String     | The identity for which the Amazon SNS topic will be set. You can specify an identity by using its name or by using its Amazon Resource Name (ARN). Examples: user@example.com, example.com, arn:aws:ses:us-east-1:123456789012:identity/example.com.
| notificationType| String     | The type of notifications that will be published to the specified Amazon SNS topic. Valid Values: Bounce; Complaint; Delivery
| snsTopic        | String     | The Amazon Resource Name (ARN) of the Amazon SNS topic. If the parameter is omitted from the request or a null value is passed, SnsTopic is cleared and publishing is disabled.

## AmazonSES.setReceiptRulePosition
Sets the position of the specified receipt rule in the receipt rule set.

| Field      | Type       | Description
|------------|------------|----------
| apiKey     | credentials| API key obtained from Amazon.
| apiSecret  | credentials| API secret obtained from Amazon.
| region     | String     | Region.
| ruleName   | String     | The name of the receipt rule to reposition.
| ruleSetName| String     | The name of the receipt rule set that contains the receipt rule to reposition.
| After      | String     | The name of the receipt rule after which to place the specified receipt rule.

## AmazonSES.updateConfigurationSetEventDestination
Updates the event destination of a configuration set.

| Field               | Type       | Description
|---------------------|------------|----------
| apiKey              | credentials| API key obtained from Amazon.
| apiSecret           | credentials| API secret obtained from Amazon.
| region              | String     | Region.
| configurationSetName| String     | The name of the configuration set that you want to update.
| eventDestination    | JSON       | The event destination object that you want to apply to the specified configuration set. See README for more details.

#### eventDestination format
```json
{
    "CloudWatchDestination":{  
        "DimensionConfigurations":[  
            {  
                "DimensionName":"NewDimension",
                "DimensionValueSource":"messageTag",
                "DefaultDimensionValue":"test"
            }
        ]
    },
    "Name": "Event_destination",
    "MatchingEventTypes": ["send"]
}
```
## AmazonSES.updateReceiptRule
Updates a receipt rule.

| Field      | Type       | Description
|------------|------------|----------
| apiKey     | credentials| API key obtained from Amazon.
| apiSecret  | credentials| API secret obtained from Amazon.
| region     | String     | Region.
| rule       | JSON       | A data structure that contains the updated receipt rule information. See README for more details.
| ruleSetName| String     | The name of the receipt rule set to which the receipt rule belongs.

#### rule format
```json
{
  "Name": "string",
  "Enabled": true|false,
  "TlsPolicy": "Require"|"Optional",
  "Recipients": ["string", ...],
  "Actions": [
    {
      "S3Action": {
        "TopicArn": "string",
        "BucketName": "string",
        "ObjectKeyPrefix": "string",
        "KmsKeyArn": "string"
      },
      "BounceAction": {
        "TopicArn": "string",
        "SmtpReplyCode": "string",
        "StatusCode": "string",
        "Message": "string",
        "Sender": "string"
      },
      "WorkmailAction": {
        "TopicArn": "string",
        "OrganizationArn": "string"
      },
      "LambdaAction": {
        "TopicArn": "string",
        "FunctionArn": "string",
        "InvocationType": "Event"|"RequestResponse"
      },
      "StopAction": {
        "Scope": "RuleSet",
        "TopicArn": "string"
      },
      "AddHeaderAction": {
        "HeaderName": "string",
        "HeaderValue": "string"
      },
      "SNSAction": {
        "TopicArn": "string",
        "Encoding": "UTF-8"|"Base64"
      }
    }
    ...
  ],
  "ScanEnabled": true|false
}
```
## AmazonSES.verifyDomainDkim
Returns a set of DKIM tokens for a domain. DKIM tokens are character strings that represent your domain's identity. Using these tokens, you will need to create DNS CNAME records that point to DKIM public keys hosted by Amazon SES. Amazon Web Services will eventually detect that you have updated your DNS records; this detection process may take up to 72 hours. Upon successful detection, Amazon SES will be able to DKIM-sign email originating from that domain.

| Field    | Type       | Description
|----------|------------|----------
| apiKey   | credentials| API key obtained from Amazon.
| apiSecret| credentials| API secret obtained from Amazon.
| region   | String     | Region.
| domain   | String     | The name of the domain to be verified for Easy DKIM signing.

## AmazonSES.verifyDomainIdentity
Verifies a domain.

| Field    | Type       | Description
|----------|------------|----------
| apiKey   | credentials| API key obtained from Amazon.
| apiSecret| credentials| API secret obtained from Amazon.
| region   | String     | Region.
| domain   | String     | The domain to be verified.

## AmazonSES.verifyEmailIdentity
Verifies an email address. This action causes a confirmation email message to be sent to the specified address.

| Field       | Type       | Description
|-------------|------------|----------
| apiKey      | credentials| API key obtained from Amazon.
| apiSecret   | credentials| API secret obtained from Amazon.
| region      | String     | Region.
| emailAddress| String     | The email address to be verified.

## AmazonSES.deleteReceiptRule
Deletes the specified receipt rule.

| Field      | Type       | Description
|------------|------------|----------
| apiKey     | credentials| API key obtained from Amazon.
| apiSecret  | credentials| API secret obtained from Amazon.
| region     | String     | Region.
| ruleName   | String     | The name of the receipt rule to delete.
| ruleSetName| String     | The name of the receipt rule set that contains the receipt rule to delete.

## AmazonSES.deleteReceiptRuleSet
Deletes the specified receipt rule set and all of the receipt rules it contains.

| Field      | Type       | Description
|------------|------------|----------
| apiKey     | credentials| API key obtained from Amazon.
| apiSecret  | credentials| API secret obtained from Amazon.
| region     | String     | Region.
| ruleSetName| String     | The name of the receipt rule set to delete.

## AmazonSES.deleteReceiptFilter
Deletes the specified IP address filter.

| Field     | Type       | Description
|-----------|------------|----------
| apiKey    | credentials| API key obtained from Amazon.
| apiSecret | credentials| API secret obtained from Amazon.
| region    | String     | Region.
| filterName| String     | The name of the IP address filter to delete.

## AmazonSES.deleteIdentityPolicy
Deletes the specified sending authorization policy for the given identity (an email address or a domain). This API returns successfully even if a policy with the specified name does not exist.

| Field     | Type       | Description
|-----------|------------|----------
| apiKey    | credentials| API key obtained from Amazon.
| apiSecret | credentials| API secret obtained from Amazon.
| region    | String     | Region.
| identity  | String     | The identity that is associated with the policy that you want to delete. You can specify the identity by using its name or by using its Amazon Resource Name (ARN). Examples: user@example.com, example.com, arn:aws:ses:us-east-1:123456789012:identity/example.com.
| policyName| String     | The name of the policy to be deleted.

## AmazonSES.deleteIdentity
Deletes the specified identity (an email address or a domain) from the list of verified identities.

| Field    | Type       | Description
|----------|------------|----------
| apiKey   | credentials| API key obtained from Amazon.
| apiSecret| credentials| API secret obtained from Amazon.
| region   | String     | Region.
| identity | String     | The identity to be removed from the list of identities for the AWS Account.

## AmazonSES.deleteConfigurationSetEventDestination
Deletes a configuration set event destination.

| Field               | Type       | Description
|---------------------|------------|----------
| apiKey              | credentials| API key obtained from Amazon.
| apiSecret           | credentials| API secret obtained from Amazon.
| region              | String     | Region.
| configurationSetName| String     | The name of the configuration set from which to delete the event destination.
| eventDestinationName| String     | The name of the event destination to delete.

## AmazonSES.deleteConfigurationSet
Deletes a configuration set..

| Field               | Type       | Description
|---------------------|------------|----------
| apiKey              | credentials| API key obtained from Amazon.
| apiSecret           | credentials| API secret obtained from Amazon.
| region              | String     | Region.
| configurationSetName| String     | The name of the configuration set from which to delete the event destination.

