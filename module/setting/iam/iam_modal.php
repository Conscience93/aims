<style>
/*ADD USER GROUP*/
.bluraddusergroup {
	-webkit-filter: blur(5px);
	-moz-filter: blur(5px);
	-o-filter: blur(5px);
	-ms-filter: blur(5px);
	filter: blur(5px);
}

.flexaddusergroup {
	min-height: 90%;
	display: flex;
	align-items: center;
	justify-content: center;
}

.modalcontaineraddusergroup {
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

.modalcontaineraddusergroup.active {
	display: block;
}

.modaladdusergroup {
	display: none;
	position: relative;
	height: 400px;
	width: 50%;
	background-color: #FFF;
	z-index:1000;
	letter-spacing:0.5px;
	font-size:20px;
}

.modaladdusergroup.active {
	display: block;
}

.modaladdusergroup .contentaddusergroup {
	padding: 20px;
}

.modaladdusergroup .closeaddusergroup {
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

.modaladdusergroup .closeaddusergroup span {
	transform: rotate(45deg);
	display: block;
}

.modaladdusergroup .buttonsaddusergroup {
	width: 100%;
	position: absolute;
	bottom: 0;
	height: 40px;
	background-color: #FFF;
	letter-spacing:0.5px;
	font-size:20px;
}

.modaladdusergroup .buttonsaddusergroup a {
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
	font-size:20px;
}

.modaladdusergroup .buttonsaddusergroup a:hover {
	background-color: #959595;
	letter-spacing:0.5px;
	font-size:20px;
}

.modaladdusergroup .buttonsaddusergroup a:nth-of-type(2) {
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
	font-size:20px;
}

.modaladdusergroup .buttonsaddusergroup a:nth-of-type(2):hover {
	background-color: #959595;
	letter-spacing:0.5px;
	font-size:20px;
}

.modalcontaddusergroup {
	padding: 20px;
    height: 300px;
    overflow-y: scroll;
}

.saveaddusergroup {
	width: 50%;
	height: 50px;
	line-height: 50px;
	text-align: center;
	float: left;
	background-color: #625eb1;
	color: white;
	transition: 0.3s;
	text-transform: uppercase;
	letter-spacing:0.5px;
	font-size:20px;
	border: none;
	outline:none;
}

.saveaddusergroup:hover {
    cursor: pointer;
	width: 50%;
	height: 50px;
	line-height: 50px;
	text-align: center;
	float: left;
	background-color: #625eb1;
	color: white;
	transition: 0.3s;
	text-transform: uppercase;
	letter-spacing:0.5px;
	font-size:20px;
	border: none;
	outline:none;
}
/*END ADD USER GROUP*/

/*EDIT USER GROUP*/
.blureditusergroup {
	-webkit-filter: blur(5px);
	-moz-filter: blur(5px);
	-o-filter: blur(5px);
	-ms-filter: blur(5px);
	filter: blur(5px);
}

.flexeditusergroup {
	min-height: 90%;
	display: flex;
	align-items: center;
	justify-content: center;
}

.modalcontainereditusergroup {
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

.modalcontainereditusergroup.active {
	display: block;
}

.modaleditusergroup {
	display: none;
	position: relative;
	height: 400px;
	width: 50%;
	background-color: #FFF;
	z-index:1000;
	letter-spacing:0.5px;
	font-size:20px;
}

.modaleditusergroup.active {
	display: block;
}

.modaleditusergroup .contenteditusergroup {
	padding: 20px;
}

.modaleditusergroup .closeeditusergroup {
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

.modaleditusergroup .closeeditusergroup span {
	transform: rotate(45deg);
	display: block;
}

.modaleditusergroup .buttonseditusergroup {
	width: 100%;
	position: absolute;
	bottom: 0;
	height: 40px;
	background-color: #FFF;
	letter-spacing:0.5px;
	font-size:20px;
}

.modaleditusergroup .buttonseditusergroup a {
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
	font-size:20px;
}

.modaleditusergroup .buttonseditusergroup a:hover {
	background-color: #959595;
	letter-spacing:0.5px;
	font-size:20px;
}

.modaleditusergroup .buttonseditusergroup a:nth-of-type(2) {
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
	font-size:20px;
}

.modaleditusergroup .buttonseditusergroup a:nth-of-type(2):hover {
	background-color: #959595;
	letter-spacing:0.5px;
	font-size:20px;
}

.modalconteditusergroup {
	padding: 20px;
    height: 300px;
    overflow-y: scroll;
}

.saveeditusergroup {
	width: 50%;
	height: 50px;
	line-height: 50px;
	text-align: center;
	float: left;
	background-color: #625eb1;
	color: white;
	transition: 0.3s;
	text-transform: uppercase;
	letter-spacing:0.5px;
	font-size:20px;
	border: none;
	outline:none;
}

.saveeditusergroup:hover {
    cursor: pointer;
	width: 50%;
	height: 50px;
	line-height: 50px;
	text-align: center;
	float: left;
	background-color: #625eb1;
	color: white;
	transition: 0.3s;
	text-transform: uppercase;
	letter-spacing:0.5px;
	font-size:20px;
	border: none;
	outline:none;
}
/*END EDIT USER GROUP*/

/*VIEW USER GROUP*/
.blurviewusergroup {
	-webkit-filter: blur(5px);
	-moz-filter: blur(5px);
	-o-filter: blur(5px);
	-ms-filter: blur(5px);
	filter: blur(5px);
}

.flexviewusergroup {
	min-height: 90%;
	display: flex;
	align-items: center;
	justify-content: center;
}

.modalcontainerviewusergroup {
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

.modalcontainerviewusergroup.active {
	display: block;
}

.modalviewusergroup {
	display: none;
	position: relative;
	height: 400px;
	width: 50%;
	background-color: #FFF;
	z-index:1000;
	letter-spacing:0.5px;
	font-size:20px;
}

.modalviewusergroup.active {
	display: block;
}

.modalviewusergroup .contentviewusergroup {
	padding: 20px;
}

.modalviewusergroup .closeviewusergroup {
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

.modalviewusergroup .closeviewusergroup span {
	transform: rotate(45deg);
	display: block;
}

.modalviewusergroup .buttonsviewusergroup {
	width: 100%;
	position: absolute;
	bottom: 0;
	height: 40px;
	background-color: #FFF;
	letter-spacing:0.5px;
	font-size:20px;
}

.modalviewusergroup .buttonsviewusergroup a {
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
	font-size:20px;
}

.modalviewusergroup .buttonsviewusergroup a:hover {
	background-color: #959595;
	letter-spacing:0.5px;
	font-size:20px;
}

.modalviewusergroup .buttonsviewusergroup a:nth-of-type(2) {
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
	font-size:20px;
}

.modalviewusergroup .buttonsviewusergroup a:nth-of-type(2):hover {
	background-color: #959595;
	letter-spacing:0.5px;
	font-size:20px;
}

.modalcontviewusergroup {
	padding: 20px;
    height: 300px;
    overflow-y: scroll;
}

.saveviewusergroup {
	width: 50%;
	height: 50px;
	line-height: 50px;
	text-align: center;
	float: left;
	background-color: #625eb1;
	color: white;
	transition: 0.3s;
	text-transform: uppercase;
	letter-spacing:0.5px;
	font-size:20px;
	border: none;
	outline:none;
}

.saveviewusergroup:hover {
    cursor: pointer;
	width: 50%;
	height: 50px;
	line-height: 50px;
	text-align: center;
	float: left;
	background-color: #625eb1;
	color: white;
	transition: 0.3s;
	text-transform: uppercase;
	letter-spacing:0.5px;
	font-size:20px;
	border: none;
	outline:none;
}
/*END VIEW USER GROUP*/
</style>

<!-- ADD USER GROUP-->  
<div class="modalcontaineraddusergroup" style="overflow:hidden">
  <div class="flexaddusergroup">
    <div class="modaladdusergroup">
      <div class="closeaddusergroup"><span>&#43;</span></div>
      <div class="contentaddusergroup">
        <h2>ADD USER GROUP</h2>
        <input type="hidden" class="greyinput" name="add_userGroupId" id="add_userGroupId">
      </div>
      <div style="height: 300px;"> <!-- scrollbar -->
        <div class="modalcontaddusergroup">     
            <div class="form-group">
                <label for="userGroup">User Group: </label>
                <input type="text" class="form-control" id="add_userGroupName" name="add_userGroupName" style="text-transform: uppercase;" oninput="this.value = this.value.toUpperCase()" >
            </div>
            <div class="form-group">
                <label for="description">Description: </label>
                <input type="text" class="form-control" id="add_userGroupDescription" name="add_userGroupDescription">
            </div>
        </div>
      <br/><br/><br/><br/> <!-- scrollbar -->
      </div> <!-- scrollbar -->
      <div class="buttonsaddusergroup">
        <input type="submit" name="submit" value="SUBMIT" style="width: 100%;" class="saveaddusergroup" />
      </div>
    </div>
  </div>
</div>
<!-- END OF ADD USER GROUP-->

<!-- EDIT USER GROUP-->  
<div class="modalcontainereditusergroup" style="overflow:hidden">
  <div class="flexeditusergroup">
    <div class="modaleditusergroup">
      <div class="closeeditusergroup"><span>&#43;</span></div>
      <div class="contenteditusergroup">
        <h2>EDIT USER GROUP</h2>
        <input type="hidden" class="greyinput" name="edit_userGroupId" id="edit_userGroupId">
      </div>
      <div style="height: 300px;"> <!-- scrollbar -->
        <div class="modalconteditusergroup">     
            <div class="form-group">
                <label for="userGroup">User Group: </label>
                <input type="text" class="form-control" id="edit_userGroupName" name="edit_userGroupName" style="text-transform: uppercase;" oninput="this.value = this.value.toUpperCase()" >
            </div>
            <div class="form-group">
                <label for="description">Description: </label>
                <input type="text" class="form-control" id="edit_userGroupDescription" name="edit_userGroupDescription">
            </div>
        </div>
      <br/><br/><br/><br/> <!-- scrollbar -->
      </div> <!-- scrollbar -->
      <div class="buttonseditusergroup">
        <input type="submit" name="ok" value="OK" style="width: 100%;" class="saveeditusergroup" />
      </div>
    </div>
  </div>
</div>
<!-- END OF EDIT USER GROUP-->

<!-- VIEW USER GROUP-->  
<div class="modalcontainerviewusergroup" style="overflow:hidden">
  <div class="flexviewusergroup">
    <div class="modalviewusergroup">
      <div class="closeviewusergroup"><span>&#43;</span></div>
      <div class="contentviewusergroup">
        <h2>USER GROUP</h2>
        <input type="hidden" class="greyinput" name="view_userGroupId" id="view_userGroupId">
      </div>
      <div style="height: 300px;"> <!-- scrollbar -->
        <div class="modalcontviewusergroup">     
            <div class="form-group">
                <label for="userGroup">User Group: </label>
                <input type="text" class="form-control" id="view_userGroupName" name="view_userGroupName" style="border: none;" readonly>
            </div>
            <div class="form-group">
                <label for="description">Description: </label>
                <input type="text" class="form-control" id="view_userGroupDescription" name="view_userGroupDescription" style="border: none;" readonly>
            </div>
        </div>
      <br/><br/><br/><br/> <!-- scrollbar -->
      </div> <!-- scrollbar -->
      <div class="buttonsviewusergroup">
        <input type="submit" name="ok" value="OK" style="width: 100%;" class="saveviewusergroup" />
      </div>
    </div>
  </div>
</div>
<!-- END OF VIEW USER GROUP-->