<style>
/*VIEW NEWS*/
.blurnewsview {
	-webkit-filter: blur(5px);
	-moz-filter: blur(5px);
	-o-filter: blur(5px);
	-ms-filter: blur(5px);
	filter: blur(5px);
}

.flexnewsview {
	min-height: 100%;
	display: flex;
	align-items: center;
	justify-content: center;
}

.modalcontainernewsview {
	display: none;
	position: absolute;
	top: 0;
	bottom: 0;
	left: 0;
	right: 0;
	background-color: rgba(0, 0, 0, 0.5);
	z-index:1020;
	min-height: 100vh;
	color:#000;
}

.modalcontainernewsview.active {
	display: block;
}

.modalnewsview {
	display: none;
	position: relative;
	height: 600px;
	width: 80%;
	background-color: #FFF;
	z-index:1000;
	letter-spacing:0.5px;
	font-size:12px;
}

.modalnewsview.active {
	display: block;
}

.modalnewsview .contentnewsview {
	padding: 20px;
}

.modalnewsview .closenewsview {
	font-family: Century Gothic;
	cursor: pointer;
	color: #FFF;
	width: 50px;
	height: 50px;
	text-align: center;
	line-height: 50px;
	position: absolute;
	right: 0;
	color: #999;
	font-size: 40px;
	letter-spacing:0.5px;
}

.modalnewsview .closenewsview span {
	transform: rotate(45deg);
	display: block;
}

.modalnewsview .buttonsnewsview {
	width: 100%;
	position: absolute;
	bottom: 0;
	height: 40px;
	background-color: #FFF;
	letter-spacing:0.5px;
	font-size:12px;
}

.modalnewsview .buttonsnewsview a {
	width: 50%;
	height: 40px;
	line-height: 40px;
	text-align: center;
	float: left;
	background-color: #959595;
	color: #000;
	transition: 0.3s;
	text-transform: uppercase;
	font-weight: bold;
	letter-spacing:0.5px;
	font-size:12px;
}

.modalnewsview .buttonsnewsview a:hover {
	background-color: #959595;
	letter-spacing:0.5px;
	font-size:12px;
}

.modalnewsview .buttonsnewsview a:nth-of-type(2) {
	float: right;
	width: 50%;
	height: 40px;
	line-height: 40px;
	text-align: center;
	float: left;
	background-color: #959595;
	color: #000;
	transition: 0.3s;
	text-transform: uppercase;
	font-weight: bold;
	border-left:1px solid black;
	letter-spacing:0.5px;
	font-size:12px;
}

.modalnewsview .buttonsnewsview a:nth-of-type(2):hover {
	background-color: #959595;
	letter-spacing:0.5px;
	font-size:12px;
}

.modalcontnewsview {
	padding: 20px;
    height: 460px;
    overflow-y: scroll;
}

.savenewsview {
	width: 50%;
	height: 40px;
	line-height: 40px;
	text-align: center;
	float: left;
	background-color: #07ff8d;
	color: #000;
	transition: 0.3s;
	text-transform: uppercase;
	font-weight: bold;
	letter-spacing:0.5px;
	font-size:12px;
	border: none;
	outline:none;
}

.savenewsview:hover {
	width: 50%;
	height: 40px;
	line-height: 40px;
	text-align: center;
	float: left;
	background-color: #07ff8d;
	color: #000;
	transition: 0.3s;
	text-transform: uppercase;
	font-weight: bold;
	letter-spacing:0.5px;
	font-size:12px;
	border: none;
	outline:none;
}
/*END VIEW NEWS*/
</style>

<!-- VIEW NEWS -->  
<div class="modalcontainernewsview" style="overflow:hidden">
  <div class="flexnewsview">
    <div class="modalnewsview">
      <div class="closenewsview"><span>&#43;</span></div>
      <div class="contentnewsview">
        <span style="font-size:16px;">VIEW NEWS</span>
        <input type="hidden" class="greyinput" name="newsId" id="newsId">
      </div>
      <div> <!-- scrollbar -->
        <div class="modalcontnewsview">     
            <!-- To be filled by ajax -->
        </div>
      <br/><br/><br/><br/> <!-- scrollbar -->
      </div> <!-- scrollbar -->
      <div class="buttonsnewsview">
        <input type="submit" name="ok" value="OK" style="width: 100%;" class="savenewsview" />
      </div>
    </div>
  </div>
</div>
<!-- END OF VIEW NEWS -->

