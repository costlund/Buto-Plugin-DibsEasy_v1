# Buto-Plugin-DibsEasy_v1


## Settings
Settings in theme settings.yml.


**data/test**

Can be true or false if in test mode.

```
plugin_modules:
  payment:
    plugin: dibs/easy_v1
```
```
plugin:
  dibs:
    easy_v1:
      enabled: true
      data:
        test: true
```


## Javascript
In html head section. It will include Javascript from dibs depending on test parameter and also this plugin Javascript.
```
type: widget
data:
  plugin: dibs/easy_v1
  method: js
```


## Widget

Checkout widget. Play around with data along with Dibs Easy documentation to fit your needs.


### Params

**account/(secret-key/checkout_key)**

This values are found on Dibs portal. Make sure param **data/test** in settings works together because there are different depending on test.

**order**

Make sure all items are correct calculated along with amount.


**checkout/charge**

If true the payment will be charged when payment are reserved. Otherwise one has to charge it on Dibs portal.

**checkout/url**

Make sure that domain along with http protocol are the same as your checkout page. For example if you are in test mode and using http://localhost the url must contain this domain as well.

**checkout/termsUrl**

Your applications terms page.

**notifications/webhooks**

Set eventName and url to get a server-to-server call from Dibs. The only one need is eventName=payment.reservation.created who is fired when payment is reserved. 


```
type: widget
data:
  plugin: dibs/easy_v1
  method: checkout
  data:
    account:
      secret-key: _YOUR_SECRET_KEY_FOR_DIBS_EASY_
      checkout-key: _YOUR_CHECKOUT_KEY_FOR_DIBS_EASY_
    order:
      items:
        -
          reference: '1'
          name: 'Candy'
          quantity: 1
          unit: pcs
          unitPrice: 1000
          taxRate: 2500
          taxAmount: 250
          grossTotalAmount: 1250
          netTotalAmount: 1000
      amount: 1250
      currency: sek
      reference: 'Demo Order'
    checkout:
      charge: true
      url: 'http://localhost/my_checkout_page_when_reservation_is_done_on_dibs_server'
      termsUrl: 'http://localhost/my_terms_page'
      shippingCountries:
        -
          countryCode: SWE
        -
          countryCode: NOR
      consumerType:
        supportedTypes:
          - B2C
          - B2B
        default: B2C
    notifications:
      webhooks:
        -
          eventName: payment.reservation.created
          url: 'http://localhost/webhook_reservation_created/order_id/1234'
          authorization: authorizationKey
    paymentMethods:
      -
        name: easy-invoice
        fee:
          reference: invFee
          name: fee
          quantity: 1
          unit: ct
          unitPrice: 1000
          taxRate: 25
          taxAmount: 250
          grossTotalAmount: 1250
          netTotalAmount: 1000
```
