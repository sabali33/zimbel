
const Zimbel_Payment = () => {
    return {
        fee : 0,
        /**
         * Configure your site's support for payment methods supported by the Google Pay
         * API.
         *
         * Each member of allowedPaymentMethods should contain only the required fields,
         * allowing reuse of this base request when determining a viewer's ability
         * to pay and later requesting a supported payment method
         *
         * @returns {object} Google Pay API version, payment methods supported by the site
         */
        getGoogleIsReadyToPayRequest() {
            return Object.assign(
                {},
                baseRequest,
                {
                allowedPaymentMethods: [baseCardPaymentMethod]
                }
            );
        },
        
        /**
         * Configure support for the Google Pay API
         *
         * @see {@link https://developers.google.com/pay/api/web/reference/request-objects#PaymentDataRequest|PaymentDataRequest}
         * @returns {object} PaymentDataRequest fields
         */
        getGooglePaymentDataRequest() {
            const paymentDataRequest = Object.assign({}, baseRequest);
            paymentDataRequest.allowedPaymentMethods = [cardPaymentMethod];
            paymentDataRequest.transactionInfo = this.getGoogleTransactionInfo();
            paymentDataRequest.merchantInfo = {
            // @todo a merchant ID is available for a production environment after approval by Google
            // See {@link https://developers.google.com/pay/api/web/guides/test-and-deploy/integration-checklist|Integration checklist}
            // merchantId: '01234567890123456789',
            merchantName: 'Zimbel Ventures'
            };
            
            return paymentDataRequest;
        },
        
        /**
         * Return an active PaymentsClient or initialize
         *
         * @see {@link https://developers.google.com/pay/api/web/reference/client#PaymentsClient|PaymentsClient constructor}
         * @returns {google.payments.api.PaymentsClient} Google Pay API client
         */
        getGooglePaymentsClient() {
            if ( paymentsClient === null ) {
            paymentsClient = new google.payments.api.PaymentsClient({environment: 'TEST'});
            }
            return paymentsClient;
        },
        
        /**
         * Initialize Google PaymentsClient after Google-hosted JavaScript has loaded
         *
         * Display a Google Pay payment button after confirmation of the viewer's
         * ability to pay.
         */
        onGooglePayLoaded() {
            const paymentsClient = this.getGooglePaymentsClient();
            paymentsClient.isReadyToPay(this.getGoogleIsReadyToPayRequest())
                .then(response => {
                if (response.result) {
                    this.addGooglePayButton();
                    this.fee = 300;
                    // @todo prefetch payment data to improve performance after confirming site functionality
                    // prefetchGooglePaymentData();
                }
                })
                .catch(err => {
                // show error in developer console for debugging
                console.error(err);
                });
        },
        
        /**
         * Add a Google Pay purchase button alongside an existing checkout button
         *
         * @see {@link https://developers.google.com/pay/api/web/reference/request-objects#ButtonOptions|Button options}
         * @see {@link https://developers.google.com/pay/api/web/guides/brand-guidelines|Google Pay brand guidelines}
         */
        addGooglePayButton() {
            const paymentsClient = this.getGooglePaymentsClient();
            const button =
                paymentsClient.createButton({onClick: this.onGooglePaymentButtonClicked.bind(this), buttonType: 'short'});
            document.getElementById('gpay-box').appendChild(button);
        },
        
        /**
         * Provide Google Pay API with a payment amount, currency, and amount status
         *
         * @see {@link https://developers.google.com/pay/api/web/reference/request-objects#TransactionInfo|TransactionInfo}
         * @returns {object} transaction info, suitable for use as transactionInfo property of PaymentDataRequest
         */
        getGoogleTransactionInfo() {
            return {
            countryCode: 'US',
            currencyCode: 'USD',
            totalPriceStatus: 'FINAL',
            // set to cart total
            totalPrice: `${this.fee}`
            };
        },
        
        /**
         * Prefetch payment data to improve performance
         *
         * @see {@link https://developers.google.com/pay/api/web/reference/client#prefetchPaymentData|prefetchPaymentData()}
         */
        prefetchGooglePaymentData() {
            const paymentDataRequest = this.getGooglePaymentDataRequest();
            // transactionInfo must be set but does not affect cache
            paymentDataRequest.transactionInfo = {
            totalPriceStatus: `${this.fee}`,
            currencyCode: 'USD'
            };
            const paymentsClient = this.getGooglePaymentsClient();
            paymentsClient.prefetchPaymentData(paymentDataRequest);
        },
        
        /**
         * Show Google Pay payment sheet when Google Pay payment button is clicked
         */
        onGooglePaymentButtonClicked() {
            const paymentDataRequest = this.getGooglePaymentDataRequest();
            paymentDataRequest.transactionInfo = this.getGoogleTransactionInfo();
        
            const paymentsClient = this.getGooglePaymentsClient();
            paymentsClient.loadPaymentData(paymentDataRequest)
                .then( paymentData => {
                // handle the response
                this.processPayment(paymentData);
                })
                .catch(err => {
                // show error in developer console for debugging
                console.error(err);
                
                });
        },
        /**
         * Process payment data returned by the Google Pay API
         *
         * @param {object} paymentData response from Google Pay API after user approves payment
         * @see {@link https://developers.google.com/pay/api/web/reference/response-objects#PaymentData|PaymentData object reference}
         */
        processPayment(paymentData) {
            
            // @todo pass payment token to your gateway to process payment
            const paymentToken = paymentData.paymentMethodData.tokenizationData.token;
            const token_input = document.querySelector('#paid');
            const billing_address = document.querySelector('#billing-address');
            //const shipping_address = document.querySelector('#shipping-address');
            token_input.setAttribute( 'value', paymentToken );
           
            billing_address.setAttribute( 'value', JSON.stringify(paymentData.paymentMethodData.info.billingAddress) );
            //shipping_address.setAttribute( 'value', JSON.stringify(paymentData.shippingAddress) );
            const form = document.querySelector('#create-customer');
            form.submit()
        }
    }
}
/**
 * Define the version of the Google Pay API referenced when creating your
 * configuration
 *
 * @see {@link https://developers.google.com/pay/api/web/reference/request-objects#PaymentDataRequest|apiVersion in PaymentDataRequest}
 */
const baseRequest = {
  apiVersion: 2,
  apiVersionMinor: 0,
  emailRequired: true,
 
};

/**
 * Card networks supported by your site and your gateway
 *
 * @see {@link https://developers.google.com/pay/api/web/reference/request-objects#CardParameters|CardParameters}
 * @todo confirm card networks supported by your site and gateway
 */
const allowedCardNetworks = ["AMEX", "DISCOVER", "INTERAC", "JCB", "MASTERCARD", "VISA"];

/**
 * Card authentication methods supported by your site and your gateway
 *
 * @see {@link https://developers.google.com/pay/api/web/reference/request-objects#CardParameters|CardParameters}
 * @todo confirm your processor supports Android device tokens for your
 * supported card networks
 */
const allowedCardAuthMethods = ["PAN_ONLY", "CRYPTOGRAM_3DS"];

/**
 * Identify your gateway and your site's gateway merchant identifier
 *
 * The Google Pay API response will return an encrypted payment method capable
 * of being charged by a supported gateway after payer authorization
 *
 * @todo check with your gateway on the parameters to pass
 * @see {@link https://developers.google.com/pay/api/web/reference/request-objects#gateway|PaymentMethodTokenizationSpecification}
 */
const tokenizationSpecification = {
  type: 'PAYMENT_GATEWAY',
  parameters: {
    'gateway': 'worldpay',
    'gatewayMerchantId': '41546a3f-f108-46e5-aa49-b17e29c75df5'
  }
};

/**
 * Describe your site's support for the CARD payment method and its required
 * fields
 *
 * @see {@link https://developers.google.com/pay/api/web/reference/request-objects#CardParameters|CardParameters}
 */
const baseCardPaymentMethod = {
  type: 'CARD',
  parameters: {
    allowedAuthMethods: allowedCardAuthMethods,
    allowedCardNetworks: allowedCardNetworks,
    billingAddressRequired: true,
    billingAddressParameters: {
      format: 'MIN'
    }
  }
};

/**
 * Describe your site's support for the CARD payment method including optional
 * fields
 *
 * @see {@link https://developers.google.com/pay/api/web/reference/request-objects#CardParameters|CardParameters}
 */
const cardPaymentMethod = Object.assign(
  {},
  baseCardPaymentMethod,
  {
    tokenizationSpecification: tokenizationSpecification
  }
);

/**
 * An initialized google.payments.api.PaymentsClient object or null if not yet set
 *
 * @see {@link getGooglePaymentsClient}
 */
let paymentsClient = null;

export default Zimbel_Payment;