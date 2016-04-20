var quote;
var formatProcentString = function (ss){
	var res = ''
	var whole = '0';
	var decimal = '00';
	if (ss.indexOf('.') > 0){
		whole = ss.substring(0, ss.indexOf('.'));
		decimal = ss.substring(ss.indexOf('.') + 1);
		if(decimal.length > 2){
			decimal = decimal.substring(0, 2);
		}
	}
	if(whole.indexOf('-') < 0){
		res = '<i class="updown-icon icon-down-big colorgreen">&#xe801;</i>' + '+' + whole + ',' + decimal + '%';
		return res;
	}
	res = '<i class="updown-icon icon-down-big colorred">&#xe800;</i>' + whole + ',' + decimal + '%';
		return res;
}
var formatProcentSimple = function (ss){
	var res = ''
	var whole = '0';
	var decimal = '00';
	if (ss.indexOf('.') > 0){
		whole = ss.substring(0, ss.indexOf('.'));
		decimal = ss.substring(ss.indexOf('.') + 1);
		if(decimal.length > 2){
			decimal = decimal.substring(0, 2);
		}
	}
	if(whole.indexOf('-') < 0){
		res = '+' + whole + ',' + decimal + '%';
		return res;
	}
	res = whole + ',' + decimal + '%';
		return res;
}
var formatPriceString = function (ss, st, unit){
	var res = ''
	var whole = '0';
	var decimal = '00';
	if (ss.indexOf('.') > 0){
		whole = ss.substring(0, ss.indexOf('.'));
		decimal = ss.substring(ss.indexOf('.') + 1);
		if(decimal.length > 2){
			decimal = decimal.substring(0, 2);
		}
	}
	if(st.indexOf('-') < 0){
		res = '<i class="updown-icon icon-down-big colorgreen">&#xe801;</i>' + '$' + whole + ',' + decimal + '/' + unit;
		return res;
	}
	res = '<i class="updown-icon icon-down-big colorred">&#xe800;</i>' +  '$' + whole + ',' + decimal + '/' + unit;
	return res;
}
var formatCurrencyString = function (ss, sc){
	var res = ''
	var whole = '0';
	var decimal = '00';
	var cwhole = '0';
	var cdecimal = '00';
	if (ss.indexOf('.') > 0){
		whole = ss.substring(0, ss.indexOf('.'));
		decimal = ss.substring(ss.indexOf('.') + 1);
		if(decimal.length > 2){
			decimal = decimal.substring(0, 2);
		}
	}
	if (sc.indexOf('.') > 0){
		cwhole = sc.substring(0, sc.indexOf('.'));
		cdecimal = sc.substring(sc.indexOf('.') + 1);
		if(cdecimal.length > 2){
			cdecimal = cdecimal.substring(0, 2);
		}
		if(cwhole.indexOf('0') == 0 || cwhole.indexOf('-0') == 0){
			cwhole = '';
			if(cdecimal.indexOf('0') == 0){ 
				cdecimal = cdecimal.substring(1, 2);
			}
		}
		
		
	}
	if(sc.indexOf('-') < 0){
		res = '<i class="updown-icon icon-down-big colorgreen">&#xe801;</i>' + whole + ',' + decimal + 'kr ' + '+' + cwhole + cdecimal + ' öre';
		return res;
	}
	res = '<i class="updown-icon icon-down-big colorred">&#xe800;</i>' +  whole + ',' + decimal + 'kr ' + '-' + cwhole + cdecimal + ' öre';
	return res;
}

var calculateCurrencyChange = function(currentPrice, oldPrice){
	var diffpc = currentPrice - oldPrice;
	var whole = '0';
	var decimal = '00';
	var dd = diffpc.toString();
	if (dd.indexOf('.') > 0){
		whole = dd.substring(0, dd.indexOf('.'));
		decimal = dd.substring(dd.indexOf('.') + 1);
		if(decimal.length > 2){
			decimal = decimal.substring(0, 2);
		}
	}
	if(diffpc > 0){
		whole = '+' + whole;
	}
	return whole + ',' + decimal;
}

var calculateYearChange = function(currentPrice, oldPrice){
	var diffpc = currentPrice / oldPrice;
	diffpc = diffpc - 1;
	diffpc = diffpc * 100;
	var whole = '0';
	var decimal = '00';
	var dd = diffpc.toString();
	if (dd.indexOf('.') > 0){
		whole = dd.substring(0, dd.indexOf('.'));
		decimal = dd.substring(dd.indexOf('.') + 1);
		if(decimal.length > 2){
			decimal = decimal.substring(0, 2);
		}
	}
	if(diffpc > 0){
		whole = '+' + whole;
	}
	return whole + ',' + decimal;
}

$.ajaxSetup({
	'cache': true
});
var getMarkets = function(){
	$.ajax({
		url: "http://finance.yahoo.com/webservice/v1/symbols/^OMXSPI,^DJI/quote?format=json&view=detail",
		dataType: "jsonp",
		jsonp: "callback",
		jsonpCallback: "quote"
	});

	quote = function (data) {
		var arrayLength = data.list.resources.length;
		var tmchange = $('.tmchange');
		var tmname = $('.tmname');
		
		for (var i = 0; i < arrayLength; i++) {
		
			var ttTime = data.list.resources[i].resource.fields.utctime;
			ttTime = ttTime.substring(ttTime.indexOf('T') + 1);
			var hoursS = ttTime.substring(0, ttTime.indexOf(':'));
			var hours = +hoursS + 1;
			ttTime = ttTime.substring(ttTime.indexOf(':') + 1);
			var mins = ttTime.substring(0, ttTime.indexOf(':'));;
			
			if(data.list.resources[i].resource.fields.symbol.indexOf('^OMXSPI') > -1 ){
				tmchange.eq(1).html( formatProcentString(data.list.resources[i].resource.fields.chg_percent));
				var yearchange = calculateYearChange(data.list.resources[i].resource.fields.price, 505);
				tmname.eq(1).html(hours + '.' + mins + ', OMX-S, i år ' + yearchange + '%');
			}
			
			else if(data.list.resources[i].resource.fields.symbol.indexOf('^DJI') > -1 ){
				tmchange.eq(0).html( formatProcentString(data.list.resources[i].resource.fields.chg_percent));
				var yearchange = calculateYearChange(data.list.resources[i].resource.fields.price, 17425);
				tmname.eq(0).html(hours + '.' + mins + ', Dow Jones, i år ' + yearchange + '%');
			}
		}
	}
}

var getMarketsAll = function(){
	$.ajax({
		url: "http://finance.yahoo.com/webservice/v1/symbols/^OMXSPI,^FIRSTNORTHSEK,^DJI,^IXIC,^GSPC,^N225,000001.SS,^HSI,^FTSE,^GDAXI,^FCHI,XAUUSD=X,XAGUSD=X,XCPUSD=X,CLU15.NYM,BZU15.NYM,NGU15.NYM,TIOU15.NYM,USDSEK=X,EURSEK=X,GBPSEK=X,DKKSEK=X,NOKSEK=X,CHFSEK=X,JPYSEK=X,CNYSEK=X/quote?format=json&view=detail",
		dataType: "jsonp",
		jsonp: "callback",
		jsonpCallback: "quote"
	});

	quote = function (data) {
		var arrayLength = data.list.resources.length;
		var procentDiv = $('.DIV_3');
		var descriptDiv = $('.DIV_5');
		var tmchange = $('.tmchange');
		var tmname = $('.tmname');
		
		for (var i = 0; i < arrayLength; i++) {
		
			var ttTime = data.list.resources[i].resource.fields.utctime;
			ttTime = ttTime.substring(ttTime.indexOf('T') + 1);
			var hoursS = ttTime.substring(0, ttTime.indexOf(':'));
			var hours = +hoursS + 1;
			ttTime = ttTime.substring(ttTime.indexOf(':') + 1);
			var mins = ttTime.substring(0, ttTime.indexOf(':'));;
			
			if(data.list.resources[i].resource.fields.symbol.indexOf('^OMXSPI') > -1 ){
				procentDiv.eq(1).html( formatProcentString(data.list.resources[i].resource.fields.chg_percent));
				tmchange.eq(1).html( formatProcentString(data.list.resources[i].resource.fields.chg_percent));
				var yearchange = calculateYearChange(data.list.resources[i].resource.fields.price, 505);
				descriptDiv.eq(1).html(hours + '.' + mins + ', OMX-S, i år ' + yearchange + '%');
				tmname.eq(1).html(hours + '.' + mins + ', OMX-S, i år ' + yearchange + '%');
			}
			else if(data.list.resources[i].resource.fields.symbol.indexOf('^FIRSTNORTHSEK') > -1 ){
				procentDiv.eq(2).html( formatProcentString(data.list.resources[i].resource.fields.chg_percent));
				var yearchange = calculateYearChange(data.list.resources[i].resource.fields.price, 57.23);
				descriptDiv.eq(2).html(hours + '.' + mins + ', FirstNorth, i år ' + yearchange + '%');
			}
			else if(data.list.resources[i].resource.fields.symbol.indexOf('^DJI') > -1 ){
				procentDiv.eq(4).html( formatProcentString(data.list.resources[i].resource.fields.chg_percent));
				tmchange.eq(0).html( formatProcentString(data.list.resources[i].resource.fields.chg_percent));
				var yearchange = calculateYearChange(data.list.resources[i].resource.fields.price, 17425);
				descriptDiv.eq(4).html(hours + '.' + mins + ', Dow Jones, i år ' + yearchange + '%');
				tmname.eq(0).html(hours + '.' + mins + ', Dow Jones, i år ' + yearchange + '%');
			}
			else if(data.list.resources[i].resource.fields.symbol.indexOf('^IXIC') > -1 ){
				procentDiv.eq(5).html( formatProcentString(data.list.resources[i].resource.fields.chg_percent));
				var yearchange = calculateYearChange(data.list.resources[i].resource.fields.price, 5007);
				descriptDiv.eq(5).html(hours + '.' + mins + ', Nasdaq, i år ' + yearchange + '%');
			}
			else if(data.list.resources[i].resource.fields.symbol.indexOf('^GSPC') > -1 ){
				procentDiv.eq(6).html( formatProcentString(data.list.resources[i].resource.fields.chg_percent));
				var yearchange = calculateYearChange(data.list.resources[i].resource.fields.price, 2043.94);
				descriptDiv.eq(6).html(hours + '.' + mins + ', S&P 500, i år ' + yearchange + '%');
			}
			else if(data.list.resources[i].resource.fields.symbol.indexOf('^N225') > -1 ){
				procentDiv.eq(8).html( formatProcentString(data.list.resources[i].resource.fields.chg_percent));
				var yearchange = calculateYearChange(data.list.resources[i].resource.fields.price, 17450.77);
				descriptDiv.eq(8).html(hours + '.' + mins + ', Nikkei, i år ' + yearchange + '%');
			}
			else if(data.list.resources[i].resource.fields.symbol.indexOf('000001.SS') > -1 ){
				procentDiv.eq(9).html( formatProcentString(data.list.resources[i].resource.fields.chg_percent));
				var yearchange = calculateYearChange(data.list.resources[i].resource.fields.price, 3234.68);
				descriptDiv.eq(9).html(hours + '.' + mins + ', Shanghai, i år ' + yearchange + '%');
			}
			else if(data.list.resources[i].resource.fields.symbol.indexOf('^HSI') > -1 ){
				procentDiv.eq(10).html( formatProcentString(data.list.resources[i].resource.fields.chg_percent));
				var yearchange = calculateYearChange(data.list.resources[i].resource.fields.price, 23605.04);
				descriptDiv.eq(10).html(hours + '.' + mins + ', Hong Kong, i år ' + yearchange + '%');
			}
			else if(data.list.resources[i].resource.fields.symbol.indexOf('^FTSE') > -1 ){
				procentDiv.eq(13).html( formatProcentString(data.list.resources[i].resource.fields.chg_percent));
				var yearchange = calculateYearChange(data.list.resources[i].resource.fields.price, 6566.10);
				descriptDiv.eq(13).html(hours + '.' + mins + ', FTSE - London, i år ' + yearchange + '%');
			}
			else if(data.list.resources[i].resource.fields.symbol.indexOf('^GDAXI') > -1 ){
				procentDiv.eq(12).html( formatProcentString(data.list.resources[i].resource.fields.chg_percent));
				var yearchange = calculateYearChange(data.list.resources[i].resource.fields.price, 9805.55);
				descriptDiv.eq(12).html(hours + '.' + mins + ', DAX - Frankfurt, i år ' + yearchange + '%');
			}
			else if(data.list.resources[i].resource.fields.symbol.indexOf('^FCHI') > -1 ){
				procentDiv.eq(14).html( formatProcentString(data.list.resources[i].resource.fields.chg_percent));
				var yearchange = calculateYearChange(data.list.resources[i].resource.fields.price, 4272.75);
				descriptDiv.eq(14).html(hours + '.' + mins + ', CAC 40 - Paris, i år ' + yearchange + '%');
			}
			else if(data.list.resources[i].resource.fields.symbol.indexOf('XAUUSD=X') > -1 ){
				procentDiv.eq(16).html(formatPriceString(data.list.resources[i].resource.fields.price, data.list.resources[i].resource.fields.chg_percent, 'oz'));
				var yearchange = calculateYearChange(data.list.resources[i].resource.fields.price, 1183.90);
				var daychange = formatProcentSimple(data.list.resources[i].resource.fields.chg_percent)
				descriptDiv.eq(16).html(hours + '.' + mins + ', Guld, i dag ' + daychange + ', i år ' + yearchange + '%');
			}
			else if(data.list.resources[i].resource.fields.symbol.indexOf('XAGUSD=X') > -1 ){
				procentDiv.eq(17).html(formatPriceString(data.list.resources[i].resource.fields.price, data.list.resources[i].resource.fields.chg_percent, 'oz'));
				var yearchange = calculateYearChange(data.list.resources[i].resource.fields.price, 15.79);
				var daychange = formatProcentSimple(data.list.resources[i].resource.fields.chg_percent)
				descriptDiv.eq(17).html(hours + '.' + mins + ', Silver, i dag ' + daychange + ', i år ' + yearchange + '%');
			}
			else if(data.list.resources[i].resource.fields.symbol.indexOf('XCPUSD=X') > -1 ){
				procentDiv.eq(18).html(formatPriceString(data.list.resources[i].resource.fields.price, data.list.resources[i].resource.fields.chg_percent, 'lb'));
				var yearchange = calculateYearChange(data.list.resources[i].resource.fields.price, 2.83);
				var daychange = formatProcentSimple(data.list.resources[i].resource.fields.chg_percent)
				descriptDiv.eq(18).html(hours + '.' + mins + ', Koppar, i dag ' + daychange + ', i år ' + yearchange + '%');
			}
			else if(data.list.resources[i].resource.fields.symbol.indexOf('CLU15.NYM') > -1 ){
				procentDiv.eq(20).html(formatPriceString(data.list.resources[i].resource.fields.price, data.list.resources[i].resource.fields.chg_percent, 'fat'));
				var yearchange = calculateYearChange(data.list.resources[i].resource.fields.price, 58.40);
				var daychange = formatProcentSimple(data.list.resources[i].resource.fields.chg_percent)
				descriptDiv.eq(20).html(hours + '.' + mins + ', Olja (VTI), i dag ' + daychange + ', i år ' + yearchange + '%');
			}
			else if(data.list.resources[i].resource.fields.symbol.indexOf('BZU15.NYM') > -1 ){
				procentDiv.eq(21).html(formatPriceString(data.list.resources[i].resource.fields.price, data.list.resources[i].resource.fields.chg_percent, 'fat'));
				var yearchange = calculateYearChange(data.list.resources[i].resource.fields.price, 64.34);
				var daychange = formatProcentSimple(data.list.resources[i].resource.fields.chg_percent)
				descriptDiv.eq(21).html(hours + '.' + mins + ', Olja (Brent), i dag ' + daychange + ', i år ' + yearchange + '%');
			}
			else if(data.list.resources[i].resource.fields.symbol.indexOf('NGU15.NYM') > -1 ){
				procentDiv.eq(22).html(formatPriceString(data.list.resources[i].resource.fields.price, data.list.resources[i].resource.fields.chg_percent, '1000 ft&#179;'));
				var yearchange = calculateYearChange(data.list.resources[i].resource.fields.price, 3.817);
				var daychange = formatProcentSimple(data.list.resources[i].resource.fields.chg_percent)
				descriptDiv.eq(22).html(hours + '.' + mins + ', Naturgas, i dag ' + daychange + ', i år ' + yearchange + '%');
			}
			else if(data.list.resources[i].resource.fields.symbol.indexOf('TIOU15.NYM') > -1 ){
				procentDiv.eq(19).html(formatPriceString(data.list.resources[i].resource.fields.price, data.list.resources[i].resource.fields.chg_percent, 'ton'));
				var yearchange = calculateYearChange(data.list.resources[i].resource.fields.price, 68.00);
				var daychange = formatProcentSimple(data.list.resources[i].resource.fields.chg_percent)
				descriptDiv.eq(19).html(hours + '.' + mins + ', Järnmalm, i dag ' + daychange + ', i år ' + yearchange + '%');
			}
			else if(data.list.resources[i].resource.fields.symbol.indexOf('USDSEK=X') > -1 ){
				var yearchange = calculateCurrencyChange(data.list.resources[i].resource.fields.price, 7.82);
				procentDiv.eq(24).html(formatCurrencyString(data.list.resources[i].resource.fields.price, data.list.resources[i].resource.fields.change));
				descriptDiv.eq(24).html(hours + '.' + mins + ', USD, i år ' + yearchange + ' kr');
			}
			else if(data.list.resources[i].resource.fields.symbol.indexOf('EURSEK=X') > -1 ){
				var yearchange = calculateCurrencyChange(data.list.resources[i].resource.fields.price, 9.39);
				procentDiv.eq(25).html(formatCurrencyString(data.list.resources[i].resource.fields.price, data.list.resources[i].resource.fields.change));
				descriptDiv.eq(25).html(hours + '.' + mins + ', Euro, i år ' + yearchange + ' kr');
			}
			else if(data.list.resources[i].resource.fields.symbol.indexOf('GBPSEK=X') > -1 ){
				var yearchange = calculateCurrencyChange(data.list.resources[i].resource.fields.price, 12.16);
				procentDiv.eq(26).html(formatCurrencyString(data.list.resources[i].resource.fields.price, data.list.resources[i].resource.fields.change));
				descriptDiv.eq(26).html(hours + '.' + mins + ', Brittiskta pund, i år ' + yearchange + ' kr');
			}
			else if(data.list.resources[i].resource.fields.symbol.indexOf('DKKSEK=X') > -1 ){
				var yearchange = calculateCurrencyChange(data.list.resources[i].resource.fields.price, 1.268);
				procentDiv.eq(27).html(formatCurrencyString(data.list.resources[i].resource.fields.price, data.list.resources[i].resource.fields.change));
				descriptDiv.eq(27).html(hours + '.' + mins + ', Danska kronor, i år ' + yearchange + ' kr');
			} 
			else if(data.list.resources[i].resource.fields.symbol.indexOf('NOKSEK=X') > -1 ){
				var yearchange = calculateCurrencyChange(data.list.resources[i].resource.fields.price, 1.046);
				procentDiv.eq(28).html(formatCurrencyString(data.list.resources[i].resource.fields.price, data.list.resources[i].resource.fields.change));
				descriptDiv.eq(28).html(hours + '.' + mins + ', Norska kronor, i år ' + yearchange + ' kr');
			}
			else if(data.list.resources[i].resource.fields.symbol.indexOf('CHFSEK=X') > -1 ){
				var yearchange = calculateCurrencyChange(data.list.resources[i].resource.fields.price, 7.85);
				procentDiv.eq(29).html(formatCurrencyString(data.list.resources[i].resource.fields.price, data.list.resources[i].resource.fields.change));
				descriptDiv.eq(29).html(hours + '.' + mins + ', Schweizerfranc, i år ' + yearchange + ' kr');
			}
			else if(data.list.resources[i].resource.fields.symbol.indexOf('JPYSEK=X') > -1 ){
				var price = '' + (data.list.resources[i].resource.fields.price * 100);
				var change = '' + (data.list.resources[i].resource.fields.change * 100);
				var yearchange = calculateCurrencyChange(price, 6.522);
				procentDiv.eq(30).html(formatCurrencyString(price, change));
				descriptDiv.eq(30).html(hours + '.' + mins + ', 100 Japanska yen, i år ' + yearchange + ' kr');
			}
			else if(data.list.resources[i].resource.fields.symbol.indexOf('CNYSEK=X') > -1 ){
				var yearchange = calculateCurrencyChange(data.list.resources[i].resource.fields.price, 1.258);
				procentDiv.eq(31).html(formatCurrencyString(data.list.resources[i].resource.fields.price, data.list.resources[i].resource.fields.change));
				descriptDiv.eq(31).html(hours + '.' + mins + ', Kinesiska yuan, i år ' + yearchange + ' kr');
			}
		}
		
	};
}

function hideAlert(){
    $("#msg_alert").html('');
}

function showAlert(msg){
    $('html, body').animate({scrollTop : 0}, 400);
    $("#msg_alert").html(msg);
    setTimeout(hideAlert, 2000);
}

function switch_language(lang){
    $.ajax({
        type: "POST",
        url: $("#basePath").val() + 'api/switch_language/'+lang,
        data: {},
        dataType: 'json',
        success: function (data) {
            window.location.reload();
        },
        error: function () {
        }
    });
}

function switch_currency(cur){
    $.ajax({
        type: "POST",
        url: $("#basePath").val() + 'api/switch_currency/'+cur,
        data: {},
        dataType: 'json',
        success: function (data) {
            window.location.reload();
        },
        error: function () {
        }
    });
}

function remove_subscribe() {
    $.ajax({
        type: "POST",
        url: $("#basePath").val() + 'api/remove_subscribe',
        data: {},
        dataType: 'json',
        success: function (data) {
            if (data.errCode==0) {
                $(".footer").fadeOut(500);
            }
        },
        error: function () {
        }
    });
}

function submit_subscribe(){
    if ($("#subscribe_email").val()=="") {
        alert("Please input email address!");
        return false;
    }
    
    $.ajax({
        type: "POST",
        url: $("#basePath").val() + 'api/submit_subscribe',
        data: { email: $("#subscribe_email").val(), status: '1' },
        dataType: 'json',
        success: function (data) {
            if (data.errCode==0) {
                remove_subscribe();
            }
        },
        error: function () {
        }
    });
}
function submit_email(){
    if ($("#add_email").val()=="") {
        alert("Skriv in din e-mailadress!");
        return false;
    }
    
    $.ajax({
        type: "POST",
        url: $("#basePath").val() + 'api/submit_email',
        data: { email: $("#add_email").val(), status: '1' },
        dataType: 'json',
        success: function (data) {
            if (data.errCode==0) {
                $(".bolagsfakta2").html("<p>Tack! Vi skickar ett e-mail till dig snart med ytterliggare information.</p>");
            }
        },
        error: function () {
        }
    });
}

function update_subscribe(email, status){
    $.ajax({
        type: "POST",
        url: $("#basePath").val() + 'api/submit_subscribe',
        data: { email: email, status: status },
        dataType: 'json',
        success: function (data) {
            if (data.errCode==0) {
                if (status=='1') {
                    remove_subscribe();
                }
            }
        },
        error: function () {
        }
    });
}

function toogle_menu(){
//    $(".header div.menu").toggleClass("visible-xs");
    $(".header div.menu.toggle").toggle(300);
}

