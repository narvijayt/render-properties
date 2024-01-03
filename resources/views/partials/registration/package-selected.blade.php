<div class="packageSel package-infobox">
    <div class="box-title-box">
        <h1 class="box-title line-left family-mont">ORDER DETAILS</h1>
        <p>Below are your order details.</p>
    </div>
    <div class="text-center selected-box">
        <h3 class="family-mont">Your Order Summary</h3>
        
        <table class="table">
            <thead>
                <tr>
                    <th>Description</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody style="text-align:left;">
                <tr>
                    <td>
						{{ $optionLabel }} 
                    </td>
                    <td>${{ $registrationPrice }} MO</u></td>
                </tr>
            
            </tbody>
            <tfoot style="text-align:left;">
                <tr>
                    <th>Total</th>
                    <th>${{ $registrationPrice }}</th>
                </tr>
            </tfoot>
        </table>
    </div>
    <div class="cancel-order text-center">
        <!---<button type="submit" class="btn btn-info-outline" id='reg-btn'>Cancel Order</button>-->
    </div>
</div>