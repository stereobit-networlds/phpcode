<section class="sidebar-page">
    <div class="container">
        
        <!-- ========================================= SIDEBAR ========================================= -->
        <div class="col-xs-12 col-sm-3 no-margin sidebar narrow">

            <!--hpdac>frontpage.include_part use /parts/widgets/sidebar/product-filter.php+++media-center</phpda-->

            <phpdac>frontpage.include_part use /parts/widgets/sidebar/category-tree.php+++media-center</phpdac>
            
            <phpdac>frontpage.include_part use /parts/widgets/sidebar/le-links.php+++media-center</phpdac>
            
            <phpdac>frontpage.include_part use /parts/widgets/sidebar/sidebar-banner.php+++media-center</phpdac>

            <phpdac>frontpage.include_part use /parts/widgets/sidebar/featured-products.php+++media-center</phpdac>
            
        </div>
        <!-- ========================================= SIDEBAR : END ========================================= -->

        <!-- ========================================= CONTENT ========================================= -->

        <div class="col-xs-12 col-sm-9 no-margin wide sidebar page-main-content">

            <?MEDIA-CENTER/INDEX?>

			<phpdac>frontpage.setGlobal use carouselID+owl-recently-viewed-2</phpdac>
			<phpdac>frontpage.setGlobal use containerClass+no-container</phpdac>			
			<phpdac>frontpage.setGlobal use productItemSize+size-medium</phpdac>
			<phpdac>frontpage.include_part use /parts/section/recently-viewed.php+++media-center</phpdac>			

        </div><!-- /.page-main-content -->
        <!-- ========================================= CONTENT : END ========================================= -->

    </div><!-- /.container -->
</section><!-- /.sidebar-page -->