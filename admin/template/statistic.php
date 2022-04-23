
<!-- start statstic  -->
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Statistics </h3>
    </div>
    <div class="panel-body">
        <div class="col-md-3 col-xs-6">
            <div class="well mystat">
                <h4><i class="fa fa-product-hunt" aria-hidden="true"></i> Products</h4>
                <h4 class="text-center"><?php echo countRows('p_id','products');?></h4>
            </div>
        </div>
        <div class="col-md-3 col-xs-6">
            <div class="well mystat" >
                <h4><i class="fa fa-shopping-cart" aria-hidden="true"></i> Carts</h4>
                <h4 class="text-center"><?php echo countRows('c_id','carts');?></h4>
            </div>
        </div>
        <div class="col-md-3 col-xs-6">
            <div class="well mystat" >
                <h4><i class="fa fa-comments"></i> Comment</h4>
                <h4 class="text-center"><?php echo countRows('com_id','comments');?></h4>
            </div>
        </div>
        <div class="col-md-3 col-xs-6">
            <div class="well mystat">
                <h4><i class="fa fa-users" aria-hidden="true"></i> Users</h4>
                <h4 class="text-center"><?php echo countRows('u_id','users');?></h4>
            </div>
        </div>
    </div>
</div>
<!-- End statstic  -->