
export const WorldPay = () => {
    return {
        load() {
            Worldpay.useTemplateForm({
              "clientKey":"T_C_d3d1a3da-9ce1-43d8-b63e-52d96decba5e", //TEST_SU_fdd41f29-665f-4224-98a4-b45eac4ab447
              "form":"create-customer",
              "paymentSection":"worldpay-section",
              "display":"inline",
              "saveButton": false,
              "reusable":true,
              "callback": function(obj) {
                if (obj && obj.token) {
                  var _el = document.createElement('input');
                  _el.value = obj.token;
                  _el.type = 'hidden';
                  _el.name = '_worldpay_token';
                  document.getElementById('create-customer').appendChild(_el);
                  document.getElementById('create-customer').submit();
                }
              }
            });
          }
    }
}