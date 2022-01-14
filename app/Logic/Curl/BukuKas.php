<?php

namespace App\Logic\Curl;

define("URL_BEECASH", "https://api.beecash.io/graphql");

class BukuKas
{
    public $ch = null;
    public $header = array(
        'accept-language: id',
        'x-client-platform: android',
        'x-client-version: 0.36.0',
        'content-type: application/json',
        'user-agent: okhttp/4.2.1',
    );
    public $token;
    public function __construct()
    {
        # code...
    }
    public function sendOtpMutation($number, $mode)
    {
        # code...
        $data = json_encode([
            "operationName" => "SendOtpMutation",
            "variables" => [
                "input" => [
                    "mobile" => "+$number",
                    "purpose" => "AUTH",
                    "mode" => "$mode"
                ],
                "key" => rand(1, 100)
            ],
            "query" => 'mutation SendOtpMutation($input: SendOtpInput!) {' . "\n" . '  sendOtp(input: $input) {' . "\n" . 'success ' . "\n" . '    __typename' . "\n" . '  }' . "\n" . '}' . "\n"
        ]);
        $result = $this->bukukas_curl($this->header, $data);
        return json_decode($result, 1);
    }
    public function verifyOtpMutation($number, $otp)
    {
        # code...
        $data = json_encode([
            "operationName" => "VerifyOtpMutation",
            "variables" => [
                "input" => [
                    "otp" => "$otp",
                    "mobile" => "+$number",
                ],
                "key" => rand(1, 100)
            ],
            "query" => 'mutation VerifyOtpMutation($input: VerifyOtpInput!) {' . "\n" . '  verifyOtp(input: $input) {' . "\n" . '    token' . "\n" . '    user {' . "\n" . '      id' . "\n" . '      mobile' . "\n" . '      sessionsCount' . "\n" . '      businesses {' . "\n" . '        id' . "\n" . '        __typename' . "\n" . '      }' . "\n" . '      __typename' . "\n" . '    }' . "\n" . '    __typename' . "\n" . '  }' . "\n" . '}' . "\n" . ''
        ]);
        $result = $this->bukukas_curl($this->header, $data);
        return json_decode($result, 1);
    }
    public function getPaymentList($bankId, $token = null)
    {
        # code...
        if (!$token) {
            $token = $this->token;
        }
        $header = array(
            "x-token: $token",
            'accept-language: id',
            'x-client-platform: android',
            'x-client-version: 0.36.0',
            'content-type: application/json',
            'user-agent: okhttp/4.2.1',
        );
        $data = json_encode([
            "operationName" => "PaymentLinksListResolver",
            "variables" => [
                "input" => [
                    "membershipBankId" => "$bankId",
                    "status" => "un_paid"
                ],
                "paging" => [
                    "limit" => 15,
                    "offset" => 0
                ],
                "sort" => [
                    "key" => "created_at",
                    "direction" => "DESC"
                ]
            ],
            "query" => 'query PaymentLinksListResolver($input: PaymentLinksListInput!, $paging: PagingInput, $sort: PaymentLinksSortInput) {' . "\n" . '  paymentLinksList(input: $input, paging: $paging, sort: $sort) {' . "\n" . '    paymentLinks {' . "\n" . '      ...paymentLink' . "\n" . '      transactionEntry {' . "\n" . '        id' . "\n" . '        createdAt' . "\n" . '        date' . "\n" . '        paymentStatus' . "\n" . '        notes' . "\n" . '        saleAmount' . "\n" . '        contact {' . "\n" . '          id' . "\n" . '          name' . "\n" . '          mobile' . "\n" . '          __typename' . "\n" . '        }' . "\n" . '        lineItems {' . "\n" . '          id' . "\n" . '          name' . "\n" . '          quantity' . "\n" . '          __typename' . "\n" . '        }' . "\n" . '        __typename' . "\n" . '      }' . "\n" . '      __typename' . "\n" . '    }' . "\n" . '    stats {' . "\n" . '      totalCount' . "\n" . '      __typename' . "\n" . '    }' . "\n" . '    __typename' . "\n" . '  }' . "\n" . '}' . "\n" . '' . "\n" . 'fragment paymentLink on PaymentLink {' . "\n" . '  id' . "\n" . '  amount' . "\n" . '  url' . "\n" . '  slug' . "\n" . '  status' . "\n" . '  createdAt' . "\n" . '  checkedOutAt' . "\n" . '  paidAt' . "\n" . '  notes' . "\n" . '  contact {' . "\n" . '    id' . "\n" . '    name' . "\n" . '    __typename' . "\n" . '  }' . "\n" . '  paymentGateway {' . "\n" . '    name' . "\n" . '    __typename' . "\n" . '  }' . "\n" . '  __typename' . "\n" . '}' . "\n" . ''
        ]);
        $result = $this->bukukas_curl($header, $data);
        return json_decode($result, 1);
    }
    public function getProfile($token = null)
    {
        # code...
        if (!$token) {
            $token = $this->token;
        }
        $header = array(
            "x-token: $token",
            'accept-language: id',
            'x-client-platform: android',
            'x-client-version: 0.36.0',
            'content-type: application/json',
            'user-agent: okhttp/4.2.1',
        );
        $query = "query AppQuery {
  currentUser {
    id
    mobile
    name
    email
    locale
    timeZone
    preferences
    businesses {
      id
      name
      mobile
      currencyCode
      email
      location
      businessCategoryId
      notes
      businessCategory {
        code
        id
        kind
        __typename
      }
      invoiceNotes
      purpose
      preferredBank {
        id
        name
        code
        __typename
      }
      __typename
    }
    businessMemberships {
      id
      role
      businessCard
      businessId
      __typename
    }
    __typename
  }
}";
        $data = json_encode([
            "operationName" => "AppQuery",
            "variables"     => (object)[],
            "query"         => $query //'query AppQuery {' . "\n" . '  currentUser {' . "\n" . '    id' . "\n" . '    mobile' . "\n" . '    name' . "\n" . '    email' . "\n" . '    locale' . "\n" . '    timeZone' . "\n" . '    pigeonCustomerToken' . "\n" . '    preferences' . "\n" . '    businesses {' . "\n" . '      id' . "\n" . '      name' . "\n" . '      mobile' . "\n" . '      currencyCode' . "\n" . '      email' . "\n" . '      location' . "\n" . '      businessCategoryId' . "\n" . '      notes' . "\n" . '      invoiceNotes' . "\n" . '      purpose' . "\n" . '      __typename' . "\n" . '    }' . "\n" . '    businessMemberships {' . "\n" . '      id' . "\n" . '      role' . "\n" . '      businessCard' . "\n" . '      businessId' . "\n" . '      __typename' . "\n" . '    }' . "\n" . '    __typename' . "\n" . '  }' . "\n" . '}' . "\n" . ''
        ]);
        $result = $this->bukukas_curl($header, $data);
        return json_decode($result, 1);
    }
    public function getMembershipBank($bisnisId, $token = null)
    {
        # code...
        if (!$token) {
            $token = $this->token;
        }
        $header = array(
            "x-token: $token",
            'accept-language: id',
            'x-client-platform: android',
            'x-client-version: 0.36.0',
            'content-type: application/json',
            'user-agent: okhttp/4.2.1',
        );
        $data = json_encode([
            "operationName" => "MembershipBankQuery",
            "variables" => [
                "businessId" => "$bisnisId"
            ],
            "query" => 'query MembershipBankQuery($businessId: ID!) {
  membershipBank(businessId: $businessId) {
    id
    businessMembership {
      user {
        name
        __typename
      }
      business {
        name
        __typename
      }
      __typename
    }
    bank {
      name
      id
      imageUrl
      code
      __typename
    }
    accountNumber
    accountName
    locked
    recoveryEmail
    recoveryPhone
    __typename
  }
}'
        ]);
        $result = $this->bukukas_curl($header, $data);
        return json_decode($result, 1);
    }
    public function generatePaymentLink($bankId, $nominal, $token = null)
    {
        # code...
        if (!$token) {
            $token = $this->token;
        }
        $header = array(
            "x-token: $token",
            'accept-language: id',
            'x-client-platform: android',
            'x-client-version: 0.36.0',
            'content-type: application/json',
            'user-agent: okhttp/4.2.1',
        );
        $data = json_encode([
            "operationName" => "GeneratePaymentLinkMutation",
            "variables" => [
                "input" => [
                    "amount" => intval($nominal),
                    "membershipBankId" =>  $bankId,
                    "contactId" => null
                ],
                "key" =>  rand(1, 100)
            ],
            "query" => 'mutation GeneratePaymentLinkMutation($input: GeneratePaymentLinkInput!) {' . "\n" . '  generatePaymentLink(input: $input) {' . "\n" . '    id' . "\n" . '    status' . "\n" . '    amount' . "\n" . '    notes' . "\n" . '    createdAt' . "\n" . '    partnerTransactionId' . "\n" . '    url' . "\n" . '    slug' . "\n" . '    contact {' . "\n" . '      id' . "\n" . '      name' . "\n" . '      mobile' . "\n" . '      __typename' . "\n" . '    }' . "\n" . '    __typename' . "\n" . '  }' . "\n" . '}' . "\n" . ''
        ]);
        $result = $this->bukukas_curl($header, $data);
        return json_decode($result, 1);
    }
    public function bukukas_curl($header, $data)
    {
        # code...
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, URL_BEECASH);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $result = curl_exec($ch);
        return $result;
    }
}
