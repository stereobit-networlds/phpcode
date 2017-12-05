<section id="cart-page">
    <div class="container">
        <!-- ========================================= CONTENT ========================================= -->
        <div class="col-xs-12 col-md-9 items-holder no-margin">
			<?MEDIA-CENTER/INDEX?>            
        </div>
        <!-- ========================================= CONTENT : END ========================================= -->

        <!-- ========================================= SIDEBAR ========================================= -->

        <div class="col-xs-12 col-md-3 no-margin sidebar ">
            <div class="widget cart-summary">
                <h1 class="border">shopping cart</h1>
                <div class="body">
                    <ul class="tabled-data no-border inverse-bold">
                        <li>
                            <label>cart subtotal</label>
                            <div class="value pull-right"><phpdac>shcart.getcartTotal</phpdac> &euro;</div>
                        </li>
                        <li>
                            <label>shipping</label>
                            <div class="value pull-right">free shipping</div>
                        </li>
                    </ul>
                    <ul id="total-price" class="tabled-data inverse-bold no-border">
                        <li>
                            <label>order total</label>
                            <div class="value pull-right"><phpdac>shcart.getcartTotal</phpdac> &euro;</div>
                        </li>
                    </ul>
                    <!--div class="buttons-holder">
                        <a class="le-button big" href="<-hpdac>rcserver.paramload use SHELL+urlbase</phpda->/index.php?page=checkout" >checkout</a>
                        <a class="simple-link block" href="<-hpdac>rcserver.paramload use SHELL+urlbase</phpda->" >continue shopping</a>
                    </div-->
                </div>
            </div><!-- /.widget -->

            <!--div id="cupon-widget" class="widget">
                <h1 class="border">use coupon</h1>
                <div class="body">
                    <form>
                        <div class="inline-input">
                            <input data-placeholder="enter coupon code" type="text" />
                            <button class="le-button" type="submit">Apply</button>
                        </div>
                    </form>
                </div>
            </div--><!-- /.widget -->
        </div><!-- /.sidebar -->

        <!-- ========================================= SIDEBAR : END ========================================= -->
    </div>
</section>