/*
 * Copyright (c) 2014, SugarCRM
 * All rights reserved.
 * 
 * Redistribution and use in source and binary forms, with or without modification,
 * are permitted provided that the following conditions are met:
 * 
 * * Redistributions of source code must retain the above copyright notice, this
 *   list of conditions and the following disclaimer.
 * 
 * * Redistributions in binary form must reproduce the above copyright notice, this
 *   list of conditions and the following disclaimer in the documentation and/or
 *   other materials provided with the distribution.
 * 
 * * Neither the name of the SugarCRM nor the names of its
 *   contributors may be used to endorse or promote products derived from
 *   this software without specific prior written permission.
 * 
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
 * ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
 * WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
 * DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR
 * ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
 * (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON
 * ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
 * SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */
(
{
    events: {
        'click .goog-res-row > .select-addr': 'setGoogRes',
//        'click .toggle-control': 'toggleChart'
    },
 
    plugins: ['Dashlet', 'Tooltip'],

    results: [ ],

    /*initialize: function (options) {
        app.view.View.prototype.initialize.call(this);
        
    },*/

    _renderHtml: function (ctx, opts) {
        this._super('_renderHtml');
        
        if(!this.meta.config ) {
            var worker = {
                view : this,
                
                getStatus: function (xml){
                    return  $(xml).find('GeocodeResponse status').text();
                },

                showError: function(){
                    worker.request( $.trim([this.view.model.get('primary_address_city'),
                        this.view.model.get('primary_address_state'),
                        this.view.model.get('primary_address_postalcode'),
                        this.view.model.get('primary_address_country')].join(' ')), true);
                },
                
                showResult: function(res){
                    var html = '';
                  
                    for(var i = 0; i < res.length; i++){
                        html += '<div row-id="'+i+'" class="goog-res-row">&nbsp;'+res[i].formatted_address+'&nbsp;<b class="select-addr" style="text-decoration: underline; cursor:pointer" >Select</b> </div>';
                    }
                    this.showHtml(html);
                },
                
                showHtml: function(html){
                    $('#address-validator-holder').html(html);
                },

                getAddressComponents: function(resThis){
                    var acList = [ ];
                    $(resThis).find('address_component').each(function(){
                        var typeList = [];
                        $(this).find('type').each(function(){ typeList.push($(this).text())  } )
                        acList.push({
                            long_name:  $(this).find('long_name').text(),
                            short_name : $(this).find('short_name').text(),
                            types:  typeList
                        });
                    });
                    return acList;
                },

                getResults: function(xml){
                    var resList = [ ];
                    $(xml).find('GeocodeResponse result').each(function(){
                        resThis = this;
                        var resObj ={
                            formatted_address: $(this).find('formatted_address').text(),
                            address_components: worker.getAddressComponents(resThis),
                            partial_match: $(this).find('partial_match').text()
                        };
                        resList.push(resObj);
                    });

                    return resList;
                },

                request:function(address, errReq){
                    $.ajax({
                        url: "https://maps-api-ssl.google.com/maps/api/geocode/xml",
                        type: "GET",
                        data: { address :address,
                            sensor:'false'},

                        dataType: "xml",
                        success : function(xml){
                            if ('OK' == worker.getStatus(xml)){
//                        console.log(worker.getResults(xml));
                                worker.view.results = worker.getResults(xml);
                                worker.showResult(worker.view.results); // : function(res){
                            }else{
                                if (!errReq){
                                    worker.showError();
                                }else{
                                    this.showHtml('No Results');
                                }
                            }
                            
                        }
                    });  
                }
            }

            
            worker.request( $.trim([ this.model.get('primary_address_street'),
                this.model.get('primary_address_city'),
                this.model.get('primary_address_state'),
                this.model.get('primary_address_postalcode'),
                this.model.get('primary_address_country')].join(' ')) );

        }
    },

    setGoogRes: function(e)
    {
        debugger;
        var resId = $(e.srcElement).parent('[row-id]').attr('row-id');
        var resObj = this.results[resId];
        var mObj = {};
        
        
        /*
        * this.model.get('primary_address_street'), 
         this.model.get('primary_address_city'), 
         this.model.get('primary_address_state'), 
         this.model.get('primary_address_postalcode'), 
         this.model.get('primary_address_country')
        * 
        * */
        
        mObj.primary_address_street = _.find(resObj.address_components, function(o){ return -1 != $.inArray('route', o.types); });
        mObj.primary_address_city = _.find(resObj.address_components, function(o){ return -1 != $.inArray('locality', o.types); });
        mObj.primary_address_state = _.find(resObj.address_components, function(o){ return -1 != $.inArray('administrative_area_level_1', o.types); });
        mObj.primary_address_postalcode = _.find(resObj.address_components, function(o){ return -1 != $.inArray('postal_code', o.types); });
        mObj.primary_address_country = _.find(resObj.address_components, function(o){ return -1 != $.inArray('country', o.types); });
 
        var str_num = _.find(resObj.address_components, function(o){ return -1 != $.inArray('street_number', o.types); });
 
        for(var i in mObj){
            if (mObj[i]){
                this.model.set(i, mObj[i].long_name)
            }
        }

		if (str_num.long_name != ""){
		   this.model.set('primary_address_street',mObj.primary_address_street.long_name + " " + str_num.long_name);
		}

		
//        this.model.save();
        
//        _.filter()
//        
        
    }


})


/*

 var worker = {
 getStatus: function (xml){
 return  $(xml).find('GeocodeResponse status').text();
 },

 showError: function(){
 alert('error');
 },

 getAddressComponents: function(resThis){
 var acList = [ ];
 $(resThis).find('address_component').each(function(){
 var typeList = [];
 $(this).find('type').each(function(){ typeList.push($(this).text())  } )                    
 acList.push({
 long_name:  $(this).find('long_name').text(),
 short_name : $(this).find('short_name').text(),
 types:  typeList
 });
 });
 return acList;
 },

 getResults: function(xml){
 var resList = [ ];
 $(xml).find('GeocodeResponse result').each(function(){
 resThis = this;
 var resObj ={
 formatted_address: $(this).find('formatted_address').text(),
 address_components: worker.getAddressComponents(resThis), 
 partial_match: $(this).find('partial_match').text()
 };
 resList.push(resObj);
 });

 return resList;
 }

 }




 console.log(worker.getStatus(xml));


 //                var r = $(xml).find('GeocodeResponse');
 //                var h = $(xml).html();
 

 //                $(xml).find('GeocodeResponse   result   address_component').each(function(){
 
 //                    var res = {
 //                        long_name : $(this).find('long_name').text(),
 //                        short_name : $(this).find('short_name').text(),
 //                        type : $(this).find('type').text() 
 //                    };
 //                    console.log(res, 'res');
 //
 //                });

 }
 });

* this.model.get('title')
*
 

* 
* */
