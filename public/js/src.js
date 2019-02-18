require('angular');
var moment = require('moment');
require('moment/locale/it');
var _ = require('lodash');

(function( $ ) {
	'use strict';

	/**
	 * On DOM ready:
	 */
	$(function() {	
        console.log('Visa PassePartout Booking by Gabriele Coquillard @ VisaMultimedia');
        moment.locale('it');
	});

	/**
	 * Angular spapp:
	 */
    var app = angular.module('vpb',[]);
    
    app.config(['$compileProvider', function($compileProvider) {
        $compileProvider.debugInfoEnabled(false);
        $compileProvider.commentDirectivesEnabled(false);
        $compileProvider.cssClassDirectivesEnabled(false);
    }]);

    app.controller('vpbController',[
        "$scope",
        "$window",
        function($scope,$window) {

            $scope.internal = {
                minNights: parseInt(vpb_options.minNights),
                maxRooms: parseInt(vpb_options.maxRooms),
                maxPeople: parseInt(vpb_options.maxPeople),
                defaultAdults: parseInt(vpb_options.defaultAdults),
                minAdultsFirstRoom: parseInt(vpb_options.minAdultsFirstRoom),
                minAdultsOtherRooms: parseInt(vpb_options.minAdultsOtherRooms),
                minArrivalDate: moment(new Date()).startOf('day').toDate(),
                url: vpb_options.url,
                queryString: '',
            }
            $scope.internal.minDepartDate = moment(new Date()).startOf('day').add(parseInt($scope.internal.minNights), 'd').toDate();
            $scope.internal.arrival = moment($scope.internal.minArrivalDate).startOf('day');
            $scope.internal.depart = moment($scope.internal.minDepartDate).startOf('day');

            $scope.form = {
                arrivalDate: moment(new Date()).startOf('day').toDate(),
                departDate: moment(new Date()).startOf('day').add(parseInt($scope.internal.minNights), 'd').toDate(),
                rooms: [{
                    id: 0,
                    adulti: parseInt(vpb_options.defaultAdults),
                    bambini: 0,
                    minAdulti: parseInt(vpb_options.minAdultsFirstRoom),
                    maxAdulti: parseInt(vpb_options.maxPeople),
                    minBambini: 0,
                    maxBambini: parseInt(vpb_options.maxPeople),
                }],
            }

            $scope.submit = {
                Albergo: vpb_options.Albergo,
                OidPortaleXAlbergo: vpb_options.OidPortaleXAlbergo,
                Lingua: 0,
                IsDateFlessibili: false,
            }

            $scope.$watch("form.rooms", function(){
                $scope.submit.Camere = $scope.form.rooms.length;
            }, true);

            $scope.$watch("form.arrivalDate", function(){
                $scope.internal.arrival = moment($scope.form.arrivalDate).startOf('day');
                $scope.internal.depart = moment($scope.form.departDate).startOf('day');
                $scope.internal.minDepartDate = moment($scope.internal.arrival.toDate()).add(parseInt($scope.internal.minNights), 'd').toDate();
            }, true);

            $scope.$watch("form.departDate", function(){
                $scope.internal.arrival = moment($scope.form.arrivalDate).startOf('day');
                $scope.internal.depart = moment($scope.form.departDate).startOf('day');
            }, true);

            $scope.addRoom = function(){
                $scope.form.rooms.push({
                    id: _.last($scope.form.rooms).id+1,
                    adulti: parseInt(vpb_options.defaultAdults),
                    bambini: 0,
                    minAdulti: parseInt(vpb_options.minAdultsOtherRooms),
                    maxAdulti: parseInt(vpb_options.maxPeople),
                    minBambini: 0,
                    maxBambini: parseInt(vpb_options.maxPeople),
                });
            }

            $scope.removeRoom = function(){
                $scope.form.rooms.splice(-1,1);
            }

            $scope.submitForm = function(){
                $scope.submit.Arrivo = $scope.internal.arrival.format('DD/MM/YYYY');
                $scope.submit.Partenza = $scope.internal.depart.format('DD/MM/YYYY');
                $scope.submit.Notti = $scope.internal.depart.diff($scope.internal.arrival, 'days');
                _.forEach($scope.form.rooms, function(value){
                    _.set($scope.submit, 'PersoneXCamera%5B' + value.id + '%5D%2EIndice', value.id);
                    _.set($scope.submit, 'PersoneXCamera%5B' + value.id + '%5D%2EAdulti', value.adulti);
                    _.set($scope.submit, 'PersoneXCamera%5B' + value.id + '%5D%2EQuantitaRiduzioni', value.bambini);
                });
                $scope.internal.queryString = _.reduce($scope.submit, function(result, value, key) { return (!_.isNull(value) && !_.isUndefined(value)) ? (result += key + '=' + value + '&') : result; }, '').slice(0, -1);
                $window.open($scope.internal.url+'?'+$scope.internal.queryString);
            }
        
    }]);
    
    app.filter('range', function() {
        return function(input, min, max) {
            min = parseInt(min);
            max = parseInt(max);
            for (var i=min; i<=max; i++)
                input.push(i);
            return input;
        };
    });

})( jQuery );