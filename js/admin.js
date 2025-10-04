//Email
// Check that an email address is valid based on RFC 821 (?)//address.indexOf('@') < 1 it changed 3 to 1 on the client request
function isValidEmail(address) 
{
	if (address.indexOf('@') < 1) return false;
	var name = address.substring(0, address.indexOf('@'));
	var domain = address.substring(address.indexOf('@') + 1);
	if (name.indexOf('(') != -1 || name.indexOf(')') != -1 || name.indexOf('<') != -1 || name.indexOf('>') != -1 || name.indexOf(',') != -1 || name.indexOf(';') != -1 || name.indexOf(':') != -1 || name.indexOf('\\') != -1 || name.indexOf('"') != -1 || name.indexOf('[') != -1 || name.indexOf(']') != -1 || name.indexOf(' ') != -1) return false;
	if (domain.indexOf('(') != -1 || domain.indexOf(')') != -1 || domain.indexOf('<') != -1 || domain.indexOf('>') != -1 || domain.indexOf(',') != -1 || domain.indexOf(';') != -1 || domain.indexOf(':') != -1 || domain.indexOf('\\') != -1 || domain.indexOf('"') != -1 || domain.indexOf('[') != -1 || domain.indexOf(']') != -1 || domain.indexOf(' ') != -1) return false;
	return true;
}
// Check that an email address has the form something@something.something
// This is a stricter standard than RFC 821 (?) which allows addresses like postmaster@localhost
function isValidEmailStrict(address)
{
	if (isValidEmail(address) == false) return false;
	var domain = address.substring(address.indexOf('@') + 1);
	if (domain.indexOf('.') == -1) return false;
	if (domain.indexOf('.') == 0 || domain.indexOf('.') == domain.length - 1) return false;
	return true;
}

//Check Numeric
function CheckNumeric(checkStr)
{
		var checknotOK = "0123456789";
		var allValid = false;
		for (i = 0;  i < checkStr.length;  i++)
		{
			ch = checkStr.charAt(i);
			ch1 = checkStr.charAt(0);
			for (k=0; k < checknotOK.length; k++)
			{
				//alert(ch+"  "+checknotOK.charAt(k));
				if (ch == checknotOK.charAt(k))
				{
					allValid = true;
					break;
				}
				if (k == checknotOK.length)
				{
					 allValid = false;
					 break;
				}
			}
		}
		return allValid;
}

//URL validation
function isUrl(s) 
{
	var regexp = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/
	return regexp.test(s);
}


//Ajax
function Inint_AJAX() {
	
   try { return new ActiveXObject("Msxml2.XMLHTTP");  } catch(e) {} //IE
   try { return new ActiveXObject("Microsoft.XMLHTTP"); } catch(e) {} //IE
   try { return new XMLHttpRequest();          } catch(e) {} //Native Javascript
   //alert("XMLHttpRequest not supported");
   return null;
};

//Index Page
function LoginValidate(loginform)
{
		var	creturn 			= 			true;
		document.getElementById('ceck_username').innerHTML		   =	'';
		document.getElementById('check_pass').innerHTML	   =	'';
		
		var username		  =	loginform.username;
		var userpass		  =	loginform.userpass;
		if(username.value=='')
		{
				document.getElementById('ceck_username').innerHTML = '<font color="#990000">Enter username</font>';
				creturn	=	false;
		}
		if(userpass.value=='')
		{
				document.getElementById('check_pass').innerHTML = '<font color="#990000">Enter password</font>';
				creturn	=	false;
		}
		return creturn;
}

//Prefrences Page
function PrefrencesValidate(frm)
{
		var	creturn 			= true;
		
		document.getElementById('check_site_title').innerHTML		=	'';
		document.getElementById('check_email_owner').innerHTML	   	=	'';
		document.getElementById('check_email_sender').innerHTML		=	'';
		document.getElementById('check_email_notify').innerHTML	   	=	'';
		
		var title_of_website		=		frm.title_of_website;
		var email_owner				=		frm.email_owner;
		var email_add_sender		=		frm.email_add_sender;
		var notify_email_add		=		frm.notify_email_add;
		
		if(title_of_website.value=='')
		{
				document.getElementById('check_site_title').innerHTML = '<font color="#990000">Enter site title</font>';
				creturn	=	false;
		}
		if(email_owner.value=='')
		{
			document.getElementById('check_email_owner').innerHTML = '<font color="#990000">Enter email id</font>';
			creturn		=	false;
		}
		if(email_owner.value!='')
		{
			if(!isValidEmailStrict(email_owner.value))
			{
				document.getElementById('check_email_owner').innerHTML = '<font color="#990000">Enter valid email id</font>';
				creturn	=	false;
			}
		}
		if(email_add_sender.value!='')
		{
			if(!isValidEmailStrict(email_add_sender.value))
			{
				document.getElementById('check_email_sender').innerHTML = '<font color="#990000">Enter valid email id</font>';
				creturn	=	false;
			}
		}
		if(notify_email_add.value!='')
		{
			if(!isValidEmailStrict(notify_email_add.value))
			{
				document.getElementById('check_email_notify').innerHTML = '<font color="#990000">Enter valid email id</font>';
				creturn	=	false;
			}
		}
		
		return creturn;
}

//Standerd User Register
function UserValidate(frm)
{
		var re =  /^[A-Za-z0-9]\w{3,}$/; 
		var re2 =  /^[A-Za-z0-9]\w{7,}$/;
		var re3 =  /^[0-9]\w{9,14}$/; 
		var re4 =  /^[0-9]\w{5,10}$/;
		var regexp = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/
		var	creturn 			= 			true;
		document.getElementById('check_user_name').innerHTML		  =		'';
		document.getElementById('check_user_password').innerHTML      =		'';
		document.getElementById('check_pass2').innerHTML		  	  =		'';
		document.getElementById('check_email').innerHTML		   	  =		'';	
		
		var user_password		  			=		frm.user_password;
		var pass2					  		=		frm.pass2;
		var user_name		  				=		frm.user_name;
		var user_email		  				=		frm.user_email;
		
		
		
		if(user_name.value=="")
		{
				document.getElementById('check_user_name').innerHTML = '<font color="#990000">Enter username</font>';
				creturn	=	false;
		}
		if(user_name.value!='')
		{
			if(!re.test(user_name.value))
			{
					document.getElementById('check_user_name').innerHTML = '<font color="#990000">Enter valid User Name allowed only chrecters and 0-9 numeric value.</font>';
					creturn	=	false;
			}
		}
		
		if(user_password.value=='')
		{
				document.getElementById('check_user_password').innerHTML = '<font color="#990000">Enter Password</font>';
				creturn	=	false;
		}
		if(user_password.value!='')
		{
			if(!re2.test(user_password.value))
			{
					document.getElementById('check_user_password').innerHTML = '<font color="#990000">Enter valid password allowed only chrecters and digits length min 8 chracters.</font>';
					creturn	=	false;
			}
		}	
		
		if(pass2.value=="")
		{
				document.getElementById('check_pass2').innerHTML = '<font color="#990000">Enter Confirm Password</font>';
				creturn	=	false;
		}
		if(pass2.value!="")
		{
			if(pass2.value!=user_password.value)
				{
					document.getElementById('check_pass2').innerHTML = '<font color="#990000">Confirm Password not match</font>';
					creturn	=	false;
				}
		}
		if(user_email.value=="")
		{
				document.getElementById('check_email').innerHTML = '<font color="#990000">Enter Email Address</font>';
				creturn	=	false;
		}
		if(user_email.value!="")
		{
			if(!isValidEmailStrict(user_email.value))
			{
				document.getElementById('check_email').innerHTML = '<font color="#990000">Enter valid Email</font>';
				creturn	=	false;	
			}
		}
		
		
		return creturn;
}
// check user name

function CheckUserName(username,check_user_name)
{
	var se =  /^[A-Za-z0-9]\w{3,}$/; 
	if(se.test(username))
	{
		var req = Inint_AJAX();
		req.onreadystatechange = function () 
		{
			if (req.readyState==4) 
			{	
				if (req.status==200) 
				{
					document.getElementById('check_user_name').innerHTML = req.responseText;
				}
			}
		};
		req.open("GET", "check/check_user_name.php?username="+username);
		req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;charset=tis-620");
		req.send(null);
	}
	else
	{
		document.getElementById(check_user_name).innerHTML = "<font color='#BC3300'>Please enter a valid username</font>";
		return false;
	}
}

//check New user registration
function NewUserValidate(frm)
{
		var re =  /^[A-Za-z0-9]\w{3,}$/; 
		var re2 =  /^[A-Za-z0-9]\w{7,}$/;
		var re3 =  /^[0-9]\w{9,14}$/; 
		var re4 =  /^[0-9]\w{5,10}$/;
		var regexp = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/
		var	creturn 			= 			true;
		document.getElementById('check_l_name').innerHTML		  =		'';
		document.getElementById('check_f_name').innerHTML		  =		'';
		document.getElementById('check_login_name').innerHTML		  =		'';
		document.getElementById('check_pass1').innerHTML		   	  =		'';
		document.getElementById('check_pass2').innerHTML		  	  =		'';
		//document.getElementById('check_user_name').innerHTML		  =		'';
		document.getElementById('check_email').innerHTML		   	  =		'';
		document.getElementById('check_weburl').innerHTML		  	  =		'';
		document.getElementById('check_user_category').innerHTML		   	=	'';
		
		var f_name		  					=		frm.f_name;
		var l_name		  					=		frm.l_name;
		var login_name		  				=		frm.login_name;
		var pass1		  					=		frm.pass1;
		var pass2					  		=		frm.pass2;
		var user_name		  				=		frm.user_name;
		var user_email		  				=		frm.user_email;
		var web_url		  				    =		frm.web_url;
		var category		  				=		frm.cate;
		
		if(l_name.value=="")
		{
				document.getElementById('check_l_name').innerHTML = '<font color="#990000">Enter Last name</font>';
				creturn	=	false;
		}
		if(f_name.value=="")
		{
				document.getElementById('check_f_name').innerHTML = '<font color="#990000">Enter First name</font>';
				creturn	=	false;
		}
		
		if(login_name.value=="")
		{
				document.getElementById('check_login_name').innerHTML = '<font color="#990000">Enter username</font>';
				creturn	=	false;
		}
		if(login_name.value!='')
		{
			if(!re.test(login_name.value))
			{
					document.getElementById('check_login_name').innerHTML = '<font color="#990000">Enter valid login name allowed only chrecters and 0-9 numeric value.</font>';
					creturn	=	false;
			}
		}
		
		if(pass1.value=='')
		{
				document.getElementById('check_pass1').innerHTML = '<font color="#990000">Enter Password</font>';
				creturn	=	false;
		}
		if(pass1.value!='')
		{
			if(!re2.test(pass1.value))
			{
					document.getElementById('check_pass1').innerHTML = '<font color="#990000">Enter valid password allowed only chrecters and digits length min 8 chracters.</font>';
					creturn	=	false;
			}
		}	
		
		if(pass2.value=="")
		{
				document.getElementById('check_pass2').innerHTML = '<font color="#990000">Enter Confirm Password</font>';
				creturn	=	false;
		}
		if(pass2.value!="")
		{
			if(pass2.value!=pass1.value)
				{
					document.getElementById('check_pass2').innerHTML = '<font color="#990000">Confirm Password not match</font>';
					creturn	=	false;
				}
		}
		if(user_email.value=="")
		{
				document.getElementById('check_email').innerHTML = '<font color="#990000">Enter Email Address</font>';
				creturn	=	false;
		}
		if(user_email.value!="")
		{
			if(!isValidEmailStrict(user_email.value))
			{
				document.getElementById('check_email').innerHTML = '<font color="#990000">Enter valid Email</font>';
				creturn	=	false;	
			}
		}
		
		if(web_url.value=="")
		{
			document.getElementById('check_weburl').innerHTML = '<font color="#990000">Enter website URL</font>';
			creturn	=	false;
		}
		if(web_url.value!="")
		{
			if(!isUrl(web_url.value))
			{
				document.getElementById('check_weburl').innerHTML = '<font color="#990000">Enter valid website URL</font>';
				creturn	=	false;	
			}
		}
		if(category.value=='')
		{
				document.getElementById('check_user_category').innerHTML = '<font color="#990000">Select Category </font>';
				creturn	=	false;
		}
		
		return creturn;
}
//check user loginname on change
function CheckUserLogin(username,check_login_name)
{
	var se =  /^[A-Za-z0-9]\w{3,}$/; 
	if(se.test(username))
	{
		var req = Inint_AJAX();
		req.onreadystatechange = function () 
		{
			if (req.readyState==4) 
			{	
				if (req.status==200) 
				{
					document.getElementById('check_login_name').innerHTML = req.responseText;
				}
			}
		};
		req.open("GET", "check/check_user_loginname.php?username="+username);
		req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;charset=tis-620");
		req.send(null);
	}
	else
	{
		document.getElementById(check_login_name).innerHTML = "<font color='#BC3300'>Please enter a valid username</font>";
		return false;
	}
}

//check newuser loginname on change
function CheckNewUserLogin(username,check_login_name)
{
	var se =  /^[A-Za-z0-9]\w{3,}$/; 
	if(se.test(username))
	{
		var req = Inint_AJAX();
		req.onreadystatechange = function () 
		{
			if (req.readyState==4) 
			{	
				if (req.status==200) 
				{
					document.getElementById('check_login_name').innerHTML = req.responseText;
				}
			}
		};
		req.open("GET", "check/check_newuser_loginname.php?username="+username);
		req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;charset=tis-620");
		req.send(null);
	}
	else
	{
		document.getElementById(check_login_name).innerHTML = "<font color='#BC3300'>Please enter a valid username</font>";
		return false;
	}
}

////Check User Email
function CheckUserEmail(username,check_email)
{
	if(isValidEmailStrict(username))
	{
		var req = Inint_AJAX();
   		  req.onreadystatechange = function () 
				{ 
					if (req.readyState==4)
					{
						if (req.status==200)
						{
							document.getElementById(check_email).innerHTML=req.responseText; 
						} 
					}
				};
     req.open("GET", "check/check_user_email.php?username="+username);
     req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;charset=tis-620");
     req.send(null); 
	}
	else
	{
		document.getElementById(check_email).innerHTML = "<font color='#990000'>Please enter a valid email </font>";
		return false;
	}
}
////Check newUser Email
function CheckNewUserEmail(username,check_email)
{
	if(isValidEmailStrict(username))
	{
		var req = Inint_AJAX();
   		  req.onreadystatechange = function () 
				{ 
					if (req.readyState==4)
					{
						if (req.status==200)
						{
							document.getElementById(check_email).innerHTML=req.responseText; 
						} 
					}
				};
     req.open("GET", "check/new_user_email.php?username="+username);
     req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;charset=tis-620");
     req.send(null); 
	}
	else
	{
		document.getElementById(check_email).innerHTML = "<font color='#990000'>Please enter a valid email </font>";
		return false;
	}
}

////Check User Email
function CheckUserSiteURL(web_url,check_weburl)
{
	if(isUrl(web_url))
	{
	var req = Inint_AJAX();
	req.onreadystatechange = function () 
	{ 
		if (req.readyState==4)
		{
			if (req.status==200)
			{
				document.getElementById(check_weburl).innerHTML=req.responseText; 
			} 
		}
	};
	req.open("GET", "check/check_user_url.php?username="+web_url);
	req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;charset=tis-620");
	req.send(null); 
	}
	else
	{
		document.getElementById(check_weburl).innerHTML = "<font color='#990000'>Please enter a valid site Url</font>";
		return false;
	}
}

//Check NewUsersiteurl Email
function CheckNewUserSiteURL(web_url,check_weburl)
{
	if(isUrl(web_url))
	{
	var req = Inint_AJAX();
	req.onreadystatechange = function () 
	{ 
		if (req.readyState==4)
		{
			if (req.status==200)
			{
				document.getElementById(check_weburl).innerHTML=req.responseText; 
			} 
		}
	};
	req.open("GET", "check/check_newuser_url.php?username="+web_url);
	req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;charset=tis-620");
	req.send(null); 
	}
	else
	{
		document.getElementById(check_weburl).innerHTML = "<font color='#990000'>Please enter a valid site Url</font>";
		return false;
	}
}

//Standerd User update
function StanderdUserUpdate(frm)
{
		var re =  /^[A-Za-z0-9]\w{3,}$/; 
		var re2 =  /^[A-Za-z0-9]\w{7,}$/;
		var re3 =  /^[0-9]\w{9,14}$/; 
		var re4 =  /^[0-9]\w{5,10}$/;
		var	creturn 			= 			true;
		document.getElementById('check_user_name').innerHTML		  =		'';
		document.getElementById('check_email').innerHTML		   	  =		'';
		document.getElementById('check_weburl').innerHTML		  	  =		'';
		
		var user_name		  				=		frm.user_name;
		var user_email		  				=		frm.user_email;
		var web_url		  				    =		frm.web_url;
		
		if(user_name.value=="")
		{
				document.getElementById('check_user_name').innerHTML = '<font color="#990000">Enter Name</font>';
				creturn	=	false;
		}
		
		if(user_email.value=="")
		{
				document.getElementById('check_email').innerHTML = '<font color="#990000">Enter Email Address</font>';
				creturn	=	false;
		}
		if(user_email.value!="")
		{
			if(!isValidEmailStrict(user_email.value))
			{
				document.getElementById('check_email').innerHTML = '<font color="#990000">Enter valid Email</font>';
				creturn	=	false;	
			}
		}
		
		if(web_url.value=="")
		{
			document.getElementById('check_weburl').innerHTML = '<font color="#990000">Enter website URL</font>';
			creturn	=	false;
		}
		if(web_url.value!="")
		{
			if(!isUrl(web_url.value))
			{
				document.getElementById('check_weburl').innerHTML = '<font color="#990000">Enter valid website URL</font>';
				creturn	=	false;	
			}
		}
		
		return creturn;
}
// check new user update

function NewUserUpdate(frm)
{
		var re =  /^[A-Za-z0-9]\w{3,}$/; 
		var re2 =  /^[A-Za-z0-9]\w{7,}$/;
		var re3 =  /^[0-9]\w{9,14}$/; 
		var re4 =  /^[0-9]\w{5,10}$/;
		var	creturn 			= 			true;
		document.getElementById('check_email').innerHTML		   	  =		'';
		var user_email		  =		frm.user_email;
		
		if(user_email.value=="")
		{
				document.getElementById('check_email').innerHTML = '<font color="#990000">Enter Email Address</font>';
				creturn	=	false;
		}
		if(user_email.value!="")
		{
			if(!isValidEmailStrict(user_email.value))
			{
				document.getElementById('check_email').innerHTML = '<font color="#990000">Enter valid Email</font>';
				creturn	=	false;	
			}
		}
		return creturn;
}

function CategoryValidate(frm)
{
		var	creturn 			= 			true;
		document.getElementById('check_user_name').innerHTML		   =	'';
		document.getElementById('check_category').innerHTML		   =	'';
		
		var user_name		  =		frm.user_name;
		var category		  =		frm.category;
		
		if(user_name.value=='')
		{
				document.getElementById('check_login_name').innerHTML = '<font color="#990000">Select Username</font>';
				creturn	=	false;
		}
		if(category.value=='')
		{
				document.getElementById('check_category').innerHTML = '<font color="#990000">Enter Category Name</font>';
				creturn	=	false;
		}
		return creturn;
}
//function new user category validate

function NewUserCategoryValidate(frm)
{
		var	creturn 			= 			true;
		document.getElementById('check_login_name').innerHTML		   		=	'';
		document.getElementById('check_user_category').innerHTML		   	=	'';
		
		var user_name		  =		frm.login_name;
		var category		  =		frm.cate;
		
		if(user_name.value=='')
		{
				document.getElementById('check_login_name').innerHTML = '<font color="#990000">Select Username</font>';
				creturn	=	false;
		}
		if(category.value=='')
		{
				document.getElementById('check_user_category').innerHTML = '<font color="#990000">Select Category </font>';
				creturn	=	false;
		}
		return creturn;
}


function ChargeValidate(frm)
{
		var	creturn 			= 			true;
		document.getElementById('check_paypal_email').innerHTML		    =	'';
		document.getElementById('check_paypal_url').innerHTML		    =	'';
		document.getElementById('check_charge_perarticle').innerHTML	=	'';
		document.getElementById('check_charge_permonth').innerHTML		=	'';
		document.getElementById('check_credit_doller').innerHTML		=	'';
		
		var paypal_email		  =		frm.paypal_email;
		var paypal_url		  	  =		frm.paypal_url;
		var charge_perarticle	  =		frm.charge_perarticle;
		var charge_permonth		  =		frm.charge_permonth;
		var credit_doller		  =		frm.credit_doller;
		
		if(paypal_email.value=='')
		{
				document.getElementById('check_paypal_email').innerHTML = '<font color="#990000">Enter Paypal Email</font>';
				creturn	=	false;
		}
		if(paypal_url.value=='')
		{
				document.getElementById('check_paypal_url').innerHTML = '<font color="#990000">Enter Paypalurl</font>';
				creturn	=	false;
		}
		if(charge_perarticle.value=='')
		{
				document.getElementById('check_charge_perarticle').innerHTML = '<font color="#990000">Enter Chaarge/Article</font>';
				creturn	=	false;
		}
		if(charge_permonth.value=='')
		{
				document.getElementById('check_charge_permonth').innerHTML = '<font color="#990000">Enter Charge/Month</font>';
				creturn	=	false;
		}
		if(credit_doller.value=='')
		{
				document.getElementById('check_credit_doller').innerHTML = '<font color="#990000">Enter credit per doller</font>';
				creturn	=	false;
		}
		return creturn;
}


//Article Validation
function Article_Validate(frm)
{
		var	creturn 			= 			true;
		document.getElementById('check_user_name').innerHTML		   =	'';
		document.getElementById('check_category_id').innerHTML		   =	'';
		document.getElementById('check_article_title').innerHTML	   =	'';
		document.getElementById('check_article').innerHTML		   	   =	'';
		
		var user_name		  =		frm.user_name;
		var category_id		  =		frm.category_id;
		var article_title	  =		frm.article_title;
		var article		  	  =		frm.article;
		
		if(user_name.value=="")
		{
			document.getElementById('check_user_name').innerHTML = '<font color="#990000">Select username</font>';
			creturn	=	false;	
		}
		if(category_id.value=="")
		{
			document.getElementById('check_category_id').innerHTML = '<font color="#990000">Select article category</font>';
			creturn	=	false;	
		}
		if(article_title.value=="")
		{
			document.getElementById('check_article_title').innerHTML = '<font color="#990000">Enter title of article</font>';
			creturn	=	false;	
		}
		if(article.value=="")
		{
			document.getElementById('check_article').innerHTML = '<font color="#990000">Select an article</font>';
			creturn	=	false;	
		}
		
		return creturn;
}


//Menu
function MenuValidate(frm)
{
		var	creturn 			= 			true;
		document.getElementById('check_category').innerHTML		   =	'';
		document.getElementById('check_item').innerHTML		   =	'';
		
		var category_kitchen		  =		frm.category_kitchen;
		var product		  					=		frm.product;
		
		if(category_kitchen.value=='')
		{
				document.getElementById('check_category').innerHTML = '<font color="#990000">Select A Category</font>';
				creturn	=	false;
		}
		if(product.value=='')
		{
				document.getElementById('check_item').innerHTML = '<font color="#990000">Enter Item Name</font>';
				creturn	=	false;
		}
		return creturn;
}

//location
function LocationValidate(frm)
{
		var	creturn 			= 			true;
		document.getElementById('check_location').innerHTML		   =	'';
		
		var location		  =		frm.location;
		
		if(location.value=='')
		{
				document.getElementById('check_location').innerHTML = '<font color="#990000">Enter Location</font>';
				creturn	=	false;
		}
		return creturn;
}

//offer
function DealValidate(frm)
{
		var	creturn 			= 			true;
		document.getElementById('check_category_name').innerHTML		  			   =	'';
		document.getElementById('check_offer').innerHTML		  			   =	'';
		document.getElementById('check_offer_description').innerHTML		   =	'';
		
		var category_name		  				=		frm.category_name;
		var offer		  				=		frm.offer;
		var offer_description		  	=		frm.offer_description;
		
		if(category_name.value=='')
		{
				document.getElementById('check_category_name').innerHTML = '<font color="#990000">Select Category</font>';
				creturn	=	false;
		}
		if(offer.value=='')
		{
				document.getElementById('check_offer').innerHTML = '<font color="#990000">Enter Offer</font>';
				creturn	=	false;
		}
		if(offer_description.value=='')
		{
				document.getElementById('check_offer_description').innerHTML = '<font color="#990000">Enter Offer Description</font>';
				creturn	=	false;
		}
		
		return creturn;
}

//Range
function RangeValidate(frm)
{
		var	creturn 			= 			true;
		document.getElementById('check_range').innerHTML		   =	'';
		
		var range		  =		frm.range;
		
		if(range.value=='')
		{
				document.getElementById('check_range').innerHTML = '<font color="#990000">Enter Range</font>';
				creturn	=	false;
		}
		return creturn;
}

//Order type
function OrderTypeValidate(frm)
{
		var	creturn 			= 			true;
		document.getElementById('check_ordertype').innerHTML		   =	'';
		
		var order_type		  =		frm.order_type;
		
		if(order_type.value=='')
		{
				document.getElementById('check_ordertype').innerHTML = '<font color="#990000">Enter Order Type</font>';
				creturn	=	false;
		}
		return creturn;
}

//Change Password
function OrderTypeValidate(frm)
{
		var	creturn 			= 			true;
		document.getElementById('check_old_pass').innerHTML		   =	'';
		document.getElementById('check_newpass').innerHTML		   =	'';
		document.getElementById('check_confirm').innerHTML		   =	'';
		
		var oldpassword		  				=		frm.oldpassword;
		var newpassword		  				=		frm.newpassword;
		var confirm_newpassword		  =		frm.confirm_newpassword;
		
		if(oldpassword.value=='')
		{
				document.getElementById('check_old_pass').innerHTML = '<font color="#990000">Enter Old Password</font>';
				creturn	=	false;
		}
		if(newpassword.value=='')
		{
				document.getElementById('check_newpass').innerHTML = '<font color="#990000">Enter New Password</font>';
				creturn	=	false;
		}
		if(confirm_newpassword.value	!=	newpassword.value)
		{
				document.getElementById('check_confirm').innerHTML = '<font color="#990000">Confirm Password Not match</font>';
				creturn	=	false;
		}
		
		return creturn;
}

//Restaurant Registration
function RestaurantValidate(frm)
{
		var re =  /^[A-Za-z0-9]\w{3,}$/; 
		var re2 =  /^[A-Za-z0-9]\w{7,}$/;
		var re3 =  /^[0-9]\w{9,14}$/; 
		var re4 =  /^[0-9]\w{5,10}$/;
		var	creturn 			= 			true;
		document.getElementById('check_loginname').innerHTML		   			=		'';
		document.getElementById('check_pass1').innerHTML		   				=		'';
		document.getElementById('check_pass2').innerHTML		  				=		'';
		document.getElementById('check_restaurant_name').innerHTML		  		=		'';
		document.getElementById('check_restaurant_email').innerHTML		  		=		'';
		document.getElementById('check_restaurant_city').innerHTML		   		=		'';
		document.getElementById('check_restaurant_street').innerHTML		    =		'';
		document.getElementById('check_restaurant_zip').innerHTML				=		'';
		document.getElementById('check_restaurant_phone').innerHTML				=		'';
		document.getElementById('check_restaurant_fax').innerHTML				=		'';
		
		var login_name		  				=		frm.login_name;
		var pass1		  					=		frm.pass1;
		var pass2					  		=		frm.pass2;
		var restaurant_name		  			=		frm.restaurant_name;
		var restaurant_email		  		=		frm.restaurant_email;
		var restaurant_city		  			=		frm.restaurant_city;
		var restaurant_street		  		=		frm.restaurant_street;
		var restaurant_zip		 			=		frm.restaurant_zip;
		var restaurant_phone		 		=		frm.restaurant_phone;
		var restaurant_fax		  			=		frm.restaurant_fax;
		
		
		if(login_name.value=='')
		{
				document.getElementById('check_loginname').innerHTML = '<font color="#990000">Enter Login Name</font>';
				creturn	=	false;
		}
		if(login_name.value!='')
		{
			if(!re.test(login_name.value))
			{
					document.getElementById('check_loginname').innerHTML = '<font color="#990000">Enter valid login name allowed only chrecters and 0-9 numeric value.</font>';
					creturn	=	false;
			}
		}
		
		if(pass1.value=='')
		{
				document.getElementById('check_pass1').innerHTML = '<font color="#990000">Enter Password</font>';
				creturn	=	false;
		}
		if(pass1.value!='')
		{
			if(!re2.test(pass1.value))
			{
					document.getElementById('check_pass1').innerHTML = '<font color="#990000">Enter valid password allowed only chrecters and digits length min 8 chracters.</font>';
					creturn	=	false;
			}
		}	
		
		if(pass2.value=="")
		{
				document.getElementById('check_pass2').innerHTML = '<font color="#990000">Enter Confirm Password</font>';
				creturn	=	false;
		}
		if(pass2.value!="")
		{
			if(pass2.value!=pass1.value)
				{
					document.getElementById('check_pass2').innerHTML = '<font color="#990000">Confirm Password not match</font>';
					creturn	=	false;
				}
		}
		if(restaurant_name.value=="")
		{
				document.getElementById('check_restaurant_name').innerHTML = '<font color="#990000">Enter restaurent name</font>';
				creturn	=	false;
		}
		
		if(restaurant_email.value=="")
		{
				document.getElementById('check_restaurant_email').innerHTML = '<font color="#990000">Enter Restaurent Email</font>';
				creturn	=	false;
		}
		if(restaurant_email.value!="")
		{
			if(!isValidEmailStrict(restaurant_email.value))
				{
					document.getElementById('check_restaurant_email').innerHTML = '<font color="#990000">Enter valid Email</font>';
					creturn	=	false;	
				}
		}
		
		if(restaurant_city.value=="")
		{
				document.getElementById('check_restaurant_city').innerHTML = '<font color="#990000">Enter Restaurant City</font>';
				creturn	=	false;
		}
		
		if(restaurant_street.value=="")
		{
				document.getElementById('check_restaurant_street').innerHTML = '<font color="#990000">Enter Restaurant Street</font>';
				creturn	=	false;
		}
		
		if(restaurant_zip.value=="")
		{
				document.getElementById('check_restaurant_zip').innerHTML = '<font color="#990000">Enter Restaurant Pin Code</font>';
				creturn	=	false;
		}
		if(restaurant_zip.value!="")
		{
				if(!re4.test(restaurant_zip.value))
				{
					document.getElementById('check_restaurant_zip').innerHTML = '<font color="#990000">Enter only numeric value Pincode must be 6 digit</font>';
					creturn	=	false;
				}
		}
		
		if(restaurant_phone.value=="")
		{
				document.getElementById('check_restaurant_phone').innerHTML = '<font color="#990000">Enter Restaurant Phono no.</font>';
				creturn	=	false;
		}
		if(restaurant_phone.value!="")
		{
				if(!re3.test(restaurant_phone.value))
				{
					document.getElementById('check_restaurant_phone').innerHTML = '<font color="#990000">Enter Only numeric value phone number must be 10 digit.</font>';
					creturn	=	false;
				}
		}
		
		if(restaurant_fax.value=="")
		{
					document.getElementById('check_restaurant_fax').innerHTML = '<font color="#990000">Enter Fax number</font>';
					creturn	=	false;
		}
		
		return creturn;
}

//check restaurant loginname on change
function CheckRestaurantLogin(username,check_loginname)
{
	var se =  /^[A-Za-z0-9]\w{3,}$/; 
	if(se.test(username))
	{
		var req = Inint_AJAX();
		req.onreadystatechange = function () 
		{
			if (req.readyState==4) 
			{	
				if (req.status==200) 
				{
					document.getElementById('check_loginname').innerHTML = req.responseText;
				}
			}
		};
		req.open("GET", "../check/check_restaurant_loginname.php?username="+username);
		req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;charset=tis-620");
		req.send(null);
	}
	else
	{
		document.getElementById(check_loginname).innerHTML = "<font color='#BC3300'>Please enter a valid username </font>";
		return false;
	}
}

//Check Restaurent Email
function CheckRestaurentEmail(username,check_restaurant_email)
{
	if(isValidEmailStrict(username))
	{
		var req = Inint_AJAX();
   		  req.onreadystatechange = function () { 
          if (req.readyState==4) {
               if (req.status==200) {
			     document.getElementById(check_restaurant_email).innerHTML=req.responseText; 
			   } 
          }
     };
     req.open("GET", "../check/chech_restaurant_email.php?username="+username);
     req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;charset=tis-620");
     req.send(null); 
	}
	else
	{
		document.getElementById(check_restaurant_email).innerHTML = "<font color='#990000'>Please enter a valid email </font>";
		return false;
	}
}

//Check Restaurent Email on edit
function CheckRestaurentUpdateEmail(username,res_id,check_restaurant_email)
{
	alert(username);
	alert(res_id);
	if(isValidEmailStrict(username))
	{
		var req = Inint_AJAX();
   		  req.onreadystatechange = function () { 
          if (req.readyState==4) {
               if (req.status==200) {
			     document.getElementById(check_restaurant_email).innerHTML=req.responseText; 
			   } 
          }
     };
     req.open("GET", "../check/check_restaurantupdate_email.php?username="+username+"&id="+res_id);
     req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;charset=tis-620");
     req.send(null); 
	}
	else
	{
		document.getElementById(check_restaurant_email).innerHTML = "<font color='#990000'>Please enter a valid email </font>";
		return false;
	}
}


//Restaurant Update Registration
function RestaurantUpdateValidate(frm)
{
		var re =  /^[A-Za-z0-9]\w{3,}$/; 
		var re2 =  /^[A-Za-z0-9]\w{7,}$/;
		var re3 =  /^[0-9]\w{9,14}$/; 
		var re4 =  /^[0-9]\w{5,10}$/;
		var	creturn 			= 			true;
		document.getElementById('check_restaurant_name').innerHTML		  =		'';
		document.getElementById('check_restaurant_email').innerHTML		  =		'';
		document.getElementById('check_restaurant_location').innerHTML	=		'';
		document.getElementById('check_restaurent_address').innerHTML		=		'';
		document.getElementById('check_phone_no').innerHTML		   				=		'';
		document.getElementById('check_pin_code').innerHTML		   				=		'';
		document.getElementById('check_order_type').innerHTML		   			=		'';
		//document.getElementById('check_restaurent_kitchen').innerHTML		=		'';
		
		var restaurant_name		  		=		frm.restaurant_name;
		var restaurant_email		  	=		frm.restaurant_email;
		var restaurant_location		  =		frm.restaurant_location;
		var restaurent_address		  =		frm.restaurent_address;
		var phone_no		  					=		frm.phone_no;
		var pin_code		 						=		frm.pin_code;
		var order_type		  				=		frm.order_type;
		//var restaurent_kitchen		  =		frm.restaurent_kitchen;
		
		if(restaurant_name.value=="")
		{
				document.getElementById('check_restaurant_name').innerHTML = '<font color="#990000">Enter restaurent name</font>';
				creturn	=	false;
		}
		
		if(restaurant_email.value=="")
		{
				document.getElementById('check_restaurant_email').innerHTML = '<font color="#990000">Enter Email</font>';
				creturn	=	false;
		}
		if(restaurant_email.value!="")
		{
			if(!isValidEmailStrict(restaurant_email.value))
				{
					document.getElementById('check_restaurant_email').innerHTML = '<font color="#990000">Enter valid Email</font>';
					creturn	=	false;	
				}
		}
		
		if(restaurant_location.value=="")
		{
				document.getElementById('check_restaurant_location').innerHTML = '<font color="#990000">Select Location</font>';
				creturn	=	false;
		}
		
		if(restaurent_address.value=="")
		{
				document.getElementById('check_restaurent_address').innerHTML = '<font color="#990000">Enter Restaurant Address</font>';
				creturn	=	false;
		}
		if(phone_no.value=="")
		{
				document.getElementById('check_phone_no').innerHTML = '<font color="#990000">Enter Restaurant Phono no.</font>';
				creturn	=	false;
		}
		if(phone_no.value!="")
		{
				if(!re3.test(phone_no.value))
				{
					document.getElementById('check_phone_no').innerHTML = '<font color="#990000">Enter Only numeric value phone number must be 10 digit.</font>';
					creturn	=	false;
				}
		}
		
		if(pin_code.value=="")
		{
				document.getElementById('check_pin_code').innerHTML = '<font color="#990000">Enter Restaurant Pin Code</font>';
				creturn	=	false;
		}
		if(pin_code.value!="")
		{
				if(!re4.test(pin_code.value))
				{
					document.getElementById('check_pin_code').innerHTML = '<font color="#990000">Enter only numeric value Pincode must be 6 digit</font>';
					creturn	=	false;
				}
		}
		
		if(order_type.value=="")
		{
				document.getElementById('check_order_type').innerHTML = '<font color="#990000">Select Order Type</font>';
				creturn	=	false;
		}
		/*if(restaurent_kitchen.value=="")
		{
				document.getElementById('check_restaurent_kitchen').innerHTML = '<font color="#990000">Select Kitchen Category</font>';
				creturn	=	false;
		}*/
		
		return creturn;
}

//User Update Information
function UserUpdate(frm)
{
		var re =  /^[A-Za-z0-9]\w{3,}$/; 
		var re2 =  /^[A-Za-z0-9]\w{7,}$/;
		var re3 =  /^[0-9]\w{9,14}$/; 
		var re4 =  /^[0-9]\w{5,10}$/;
		var	creturn 			= 			true;
		document.getElementById('check_user_name').innerHTML		  		=		'';
		document.getElementById('check_sur_name').innerHTML		  			=		'';
		document.getElementById('check_phone_no').innerHTML						=		'';
		document.getElementById('check_zip_code').innerHTML						=		'';
		document.getElementById('check_address').innerHTML						=		'';
		
		var user_name		  					=		frm.user_name;
		var sur_name		  					=		frm.sur_name;
		var phone_no		  					=		frm.phone_no;
		var zip_code		 						=		frm.zip_code;
		var address		 				=		frm.address;
		
		if(user_name.value=="")
		{
				document.getElementById('check_user_name').innerHTML = '<font color="#990000">Enter Name</font>';
				creturn	=	false;
		}
		
		if(sur_name.value=="")
		{
				document.getElementById('check_sur_name').innerHTML = '<font color="#990000">Enter Restaurant Address</font>';
				creturn	=	false;
		}
		if(phone_no.value=="")
		{
				document.getElementById('check_phone_no').innerHTML = '<font color="#990000">Enter Restaurant Phono no.</font>';
				creturn	=	false;
		}
		if(phone_no.value!="")
		{
				if(!re3.test(phone_no.value))
				{
					document.getElementById('check_phone_no').innerHTML = '<font color="#990000">Enter Only numeric value phone number must be 10 digit.</font>';
					creturn	=	false;
				}
		}
		
		if(zip_code.value=="")
		{
				document.getElementById('check_zip_code').innerHTML = '<font color="#990000">Enter Restaurant Pin Code</font>';
				creturn	=	false;
		}
		if(zip_code.value!="")
		{
				if(!re4.test(zip_code.value))
				{
					document.getElementById('check_zip_code').innerHTML = '<font color="#990000">Enter only numeric value Pincode must be 6 digit</font>';
					creturn	=	false;
				}
		}
		
		if(address.value=="")
		{
					document.getElementById('check_address').innerHTML = '<font color="#990000">Enter Address</font>';
					creturn	=	false;
		}
		
		return creturn;
}

//FAQ
function FAQValidate(frm)
{
		var	creturn 			= 			true;
		document.getElementById('check_question').innerHTML		   =	'';
		document.getElementById('check_answer').innerHTML		   =	'';
		
		var question		  				=		frm.question;
		var answer		  				=		frm.answer;
		
		if(question.value=='')
		{
				document.getElementById('check_question').innerHTML = '<font color="#990000">Enter Question</font>';
				creturn	=	false;
		}
		if(answer.value=='')
		{
				document.getElementById('check_answer').innerHTML = '<font color="#990000">Enter Answer</font>';
				creturn	=	false;
		}
		
		return creturn;
}

//Advertisement Validation
function Advertise_Validate(frm)
{
		var	creturn 			= 			true;
		document.getElementById('check_image').innerHTML		   =	'';
		document.getElementById('check_script').innerHTML		   =	'';
		document.getElementById('check_side').innerHTML		   	   =	'';
		
		var add_image		  				=		frm.add_image;
		var add_script		  				=		frm.add_script;
		var image		  					=		frm.image;
		var script		  					=		frm.script;
		var page_side		  				=		frm.page_side;
		
		if(document.getElementById('add_image').checked==true)
		{
			if(image.value=="")
			{
				document.getElementById('check_image').innerHTML = '<font color="#990000">Enter Image</font>';
				creturn	=	false;	
			}
		}
		if(document.getElementById('add_script').checked==true)
		{
			if(script.value=="")
			{
				document.getElementById('check_script').innerHTML = '<font color="#990000">Enter Script or text</font>';
				creturn	=	false;	
			}
		}
		if(page_side.value=="")
			{
				document.getElementById('check_side').innerHTML = '<font color="#990000">Enter page side</font>';
				creturn	=	false;	
			}
		
		return creturn;
}

function TimeValidate(frm)
{
		var	creturn 			= 			true;
		document.getElementById('check_lunch_time').innerHTML		   =	'';
		document.getElementById('check_diner_time').innerHTML		   =	'';
		document.getElementById('check_late_time').innerHTML		   =	'';
		
		var lunch_time		  =		frm.lunch_time;
		var diner_time		  =		frm.diner_time;
		var late_time		  =		frm.late_time;
		
		if(lunch_time.value=='')
		{
				document.getElementById('check_lunch_time').innerHTML = '<font color="#990000">Enter Lunch Time</font>';
				creturn	=	false;
		}
		if(diner_time.value=='')
		{
				document.getElementById('check_diner_time').innerHTML = '<font color="#990000">Enter Diner Time</font>';
				creturn	=	false;
		}
		if(late_time.value=='')
		{
				document.getElementById('check_late_time').innerHTML = '<font color="#990000">Enter Late night Time</font>';
				creturn	=	false;
		}
		return creturn;
}




