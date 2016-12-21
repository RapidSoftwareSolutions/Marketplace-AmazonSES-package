<?php

namespace Test\Functional;

require_once(__DIR__ . '/../../src/Models/checkRequest.php');

class AmazonSESTest extends BaseTestCase {
    
    public function testPackage() {
        
        $routes = [
            'createConfigurationSet',
            'createConfigurationSetEventDestination',
            'createReceiptFilter',
            'createReceiptRuleSet',
            'createReceiptRule',
            'describeActiveReceiptRuleSet',
            'describeConfigurationSet',
            'describeReceiptRule',
            'describeReceiptRuleSet',
            'getIdentityDkimAttributes',
            'getIdentityMailFromDomainAttributes',
            'getIdentityNotificationAttributes',
            'getIdentityPolicies',
            'getIdentityVerificationAttributes',
            'getSendQuota',
            'getSendStatistics',
            'listConfigurationSets',
            'listIdentities',
            'listIdentityPolicies',
            'listReceiptFilters',
            'listReceiptRuleSets',
            'putIdentityPolicy',
            'reorderReceiptRuleSet',
            'sendBounce',
            'sendEmail',
            'sendPlainEmail',
            'sendRawEmail',
            'setActiveReceiptRuleSet',
            'setIdentityDkimEnabled',
            'setIdentityFeedbackForwardingEnabled',
            'setIdentityHeadersInNotificationsEnabled',
            'setIdentityMailFromDomain',
            'setIdentityNotificationTopic',
            'setReceiptRulePosition',
            'updateConfigurationSetEventDestination',
            'updateReceiptRule',
            'verifyDomainDkim',
            'verifyDomainIdentity',
            'verifyEmailIdentity',
            'cloneReceiptRuleSet',
            'deleteReceiptRule',
            'deleteReceiptRuleSet',
            'deleteReceiptFilter',
            'deleteIdentityPolicy',
            'deleteIdentity',
            'deleteConfigurationSetEventDestination',
            'deleteConfigurationSet'
        ];
        
        foreach($routes as $file) {
            $var = '{  
                        "args":{  
                            "apiKey": "AKIAJIVNVSZ7PUVJFLQQ",
                            "apiSecret": "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",
                            "region": "eu-west-1"
                        }
                    }';
            $post_data = json_decode($var, true);

            $response = $this->runApp('POST', '/api/AmazonSES/'.$file, $post_data);

            $this->assertEquals(200, $response->getStatusCode(), 'Error in '.$file.' method');
        }
    }
    
}
