<!-- 
 /////////////////// DISCLAIMER ///////////////////////////
 THIS EXAMPLE CODE IS PROVIDED TO YOU ONLY ON AN "AS IS"
 BASIS WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND,
 EITHER EXPRESS OR IMPLIED, INCLUDING WITHOUT LIMITATION
 ANY WARRANTIES OR CONDITIONS OF TITLE, NON-INFRINGEMENT,
 MERCHANTABILITY OR FITNESS FOR A PARTICULAR PURPOSE.
 PAYPAL MAKES NO WARRANTY THAT THE SOFTWARE OR
 DOCUMENTATION WILL BE ERROR-FREE. IN NO EVENT SHALL THE
 COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY
 DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
 CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO,
 PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF
 USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT,
 STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF
 ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 ////////////////////////////////////////////////////////////
 */
  -->
<!DOCTYPE html>

<head>
    <!-- Add meta tags for mobile and IE -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
</head>

<body>
    <!-- Set up a container element for the button -->
    <div id="paypal-button-container"></div>

    <!-- Include the PayPal JavaScript SDK -->
    <!-- Add 'intent=authorize' if you only want to authorize the payment -->
    <!-- https://developer.paypal.com/docs/checkout/reference/customize-sdk/#disable-funding -->
    <script src="https://www.paypal.com/sdk/js?client-id=ARSqHC295J546ZD6NANrJMi7ZS7YCJhQaQc1qDBwwKY1Aqxkm0YuiSxvBGHzZH4iWMPNynrAu0SeKw-o"></script>

    <script>
        // Render the PayPal button into #paypal-button-container
        paypal.Buttons({
            // Set up the transaction
            createOrder: function(data, actions) {
                console.log("Smart Button was clicked, initiate create order:");
                //Setup path to create order file
                return fetch('create_order.php').then(function(res) {
                    return res.json();
                }).then(function(order) {
                    console.log("Create order executed, response: ", order);
                    return order.id;
                });
            },


            // Finalise the transaction
            onApprove: function(data, actions) {
                console.log("Preparing to capture order with orderId: ", data.orderID);
                return fetch('capture_payment.php?id=' + data.orderID).then(function(res) {
                    return res.json();
                }).then(function(orderData) {
                    console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));
                    const trans = orderData.purchase_units[0].payments.captures[0];
                    // Show message to the buyer
                    alert(`Transaction id ${trans.id}, status ${trans.status}`);
                    //Once payment is complete show the order details
                    //window.location.replace("showOrderDetails.php");
                });
            },

        }).render('#paypal-button-container');
    </script>

</body>