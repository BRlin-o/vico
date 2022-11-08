<style>
body{
	--hg: calc(100vh - 30px);
}
#box1{
	height: var(--hg);
    position: relative;
    background-color: #000;
    overflow: hidden;
}
#box1 .bg{
    position: absolute;
	top: 0;
	height: var(--hg);
    width: 100%;
	background-image: url('//<?php echo $domainName;?>/img/img01.jpg');
    background-repeat: no-repeat;
    background-size: cover;
    background-position: right;
	opacity: 0.6;
}
#box1 .inb{
    position: absolute;
	top: 0;
	height: var(--hg);
    width: 100%;
	
}
#box1 .img{
    height: 80px;
    margin: 0px 12px;
}
#box1 .bar{
    position: absolute;
	top: 0;
	right: 24px;
    height: 80px;
	display: flex;	
    align-items: center;
}
#box1 .bar .btn{
    padding: 8px 18px;
    border: 1px solid #d9d9d9;
    color: #d9d9d9;
    background-color: #00000080;
    border-radius: 6px;
    font-size: 18px;
    text-decoration: none;
    cursor: pointer;
}
#box1 .bar .btn:hover{
    border: 1px solid #ffffff;
    color: #ffffff;
    background-color: #0000004d;
}
.box{
	height: 50vh;
	background-color: #e5e5e5;
	border-top: 1px solid #00000033;
}
.box:nth-child(odd){
	background-color: #f9f9f9;
}
</style>
<div id='box1'>
	<div class='bg'></div>
	<div class='inb'>
		<img class='img' src='//<?php echo $domainName;?>/img/img02.png'>
	</div>
	<div class='bar'>
		<a class='btn' href='//<?php echo $domainName;?>/login'>Login</a>
	</div>
</div>
<div id='box2' class='box'>
</div>
<div id='box3' class='box'>
	
</div>
<div id='box4' class='box'>
	
</div>