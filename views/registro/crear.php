<main class="registro">
    <h2 class="registro__heading"><?php echo $titulo ?></h2>
    <p class="registro__descripcion">Elige tu plan</p>
    <div class="paquetes__grid">
        <div class="paquete">
            <h3 class="paquete__nombre">
                Pase Gratis.
            </h3>
            <ul class="paquete__lista">
                <li class="paquete__elemento">Acceso Virtual a DevWebCamp</li>
            </ul>
            <p class="paquete__precio">$ 0.00</p>
            <form action="/finalizar-registro/gratis" method="POST">
                <input type="submit" class="paquetes__submit" value="Inscripción Gratuita">
            </form>

            
        </div>
        <div class="paquete">
            <h3 class="paquete__nombre">
                Pase Presencial.
            </h3>
                <ul class="paquete__lista">
                    <li class="paquete__elemento">Acceso Virtual a DevWebCamp</li>
                    <li class="paquete__elemento">Pase para 2 días</li>
                    <li class="paquete__elemento">Acceso a Talleres y conferencias</li>
                    <li class="paquete__elemento">Acceso a las Grabaciones</li>
                    <li class="paquete__elemento">Camisa del evento</li>
                    <li class="paquete__elemento">Comida y Bebida</li>
                </ul>
                <p class="paquete__precio">$ 199.00</p>
                <div id="smart-button-container">
                    <div style="text-align: center;">
                        <div id="paypal-button-container">    
                    </div>
                </div>
    </div>
        </div>
        <div class="paquete">
            <h3 class="paquete__nombre">
                Pase Virtual.
            </h3>
                <ul class="paquete__lista">
                    <li class="paquete__elemento">Acceso Virtual a DevWebCamp</li>
                    <li class="paquete__elemento">Pase para 2 días</li>
                    <li class="paquete__elemento">Acceso a Talleres y conferencias</li>
                    <li class="paquete__elemento">Acceso a las Grabaciones</li>
                </ul>
                <p class="paquete__precio">$ 49.00</p>
                <div id="smart-button-container">
                    <div style="text-align: center;">
                        <div id="paypal-button-container-virtual"></div>
                    </div>
                </div>
        </div>
    </div>

</main>


  <script src="https://www.paypal.com/sdk/js?client-id=AYFTGFqcdB0kLBcq-wTCBt6ooJfWmz5FjO75Idgpccpe9Y2y4_4nGetsT7KrbEujqm0msyMzRiW_XAJx&enable-funding=venmo&currency=USD" data-sdk-integration-source="button-factory"></script>
  <script>
    function initPayPalButton() {
      paypal.Buttons({
        style: {
          shape: 'rect',
          color: 'blue',
          layout: 'vertical',
          label: 'pay',
          
        },

        createOrder: function(data, actions) {
          return actions.order.create({
            purchase_units: [{"description":"1","amount":{"currency_code":"USD","value":230.84,"breakdown":{"item_total":{"currency_code":"USD","value":199},"shipping":{"currency_code":"USD","value":0},"tax_total":{"currency_code":"USD","value":31.84}}}}]
          });
        },

        onApprove: function(data, actions) {
          return actions.order.capture().then(function(orderData) {
            
            // Full available details
            console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));

            // Show a success message within this page, e.g.

            // Or go to another URL:  actions.redirect('thank_you.html');
            const datos = new FormData();
            datos.append('paquete_id', orderData.purchase_units[0].description);
            datos.append('pago_id', orderData.purchase_units[0].payments.captures[0].id);

            fetch('/finalizar-registro/pagar', {
                method: 'POST',
                body: datos
            })
            .then(respuesta => respuesta.json())
            .then(resultado => {
                if(resultado.resultado){
                    actions.redirect('http://localhost:3000/finalizar-registro/conferencias');
                }
            })
            // Or go to another URL:  actions.redirect('thank_you.html');

          });
        },

        onError: function(err) {
          console.log(err);
        }
      }).render('#paypal-button-container');

      paypal.Buttons({
        style: {
          shape: 'rect',
          color: 'blue',
          layout: 'vertical',
          label: 'pay',
          
        },

        createOrder: function(data, actions) {
          return actions.order.create({
            purchase_units: [{"description":"2","amount":{"currency_code":"USD","value":56.84,"breakdown":{"item_total":{"currency_code":"USD","value":49},"shipping":{"currency_code":"USD","value":0},"tax_total":{"currency_code":"USD","value":7.84}}}}]
          });
        },

        onApprove: function(data, actions) {
          return actions.order.capture().then(function(orderData) {
            
            // Full available details
            console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));

            // Show a success message within this page, e.g.
            const datos = new FormData();
            datos.append('paquete_id', orderData.purchase_units[0].description);
            datos.append('pago_id', orderData.purchase_units[0].payments.captures[0].id);

            fetch('/finalizar-registro/pagar', {
                method: 'POST',
                body: datos
            })
            .then(respuesta => respuesta.json())
            .then(resultado => {
                if(resultado.resultado){
                    actions.redirect('http://localhost:3000/finalizar-registro/conferencias');
                }
            })
            // Or go to another URL:  actions.redirect('thank_you.html');
            
          });
        },

        onError: function(err) {
          console.log(err);
        }
      }).render('#paypal-button-container-virtual');
    } initPayPalButton();
  </script>