# Buto-Plugin-DibsEasy_v1



Settings in theme settings.yml.
Param data/test can be true or false if in test mode.
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



In html head section. It will include Javascript from dibs depending on test parameter and also this plugin Javascript.
```
-
  type: widget
  data:
    plugin: dibs/easy_v1
    method: js
```

Checkout widget. Play around with data along with Dibs Easy documentation to fit your needs.
```
-
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
            eventName: payment.created
            url: 'http://localhost/webhook_payment_created'
            authorization: authorizationKey
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
