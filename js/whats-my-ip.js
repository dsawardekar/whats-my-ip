(function($) {

  var IpFinder = function() {
    this.apiUrl = 'http://www.telize.com/geoip?callback=?';
  };

  IpFinder.prototype.find = function() {
    return $.getJSON(this.apiUrl);
  };

  var DivLocator = function() {
    this.className = 'whats-my-ip';
  };

  DivLocator.prototype.locate = function() {
    var foundDivs = $(this.getSelector('div'));
    foundDivs.push.apply(foundDivs, $(this.getSelector('span')));

    var total     = foundDivs.length;
    var divs      = [];
    var opts, foundDiv;

    for (var i = 0; i < total; i++) {
      foundDiv = foundDivs[i];
      opts     = this.optionsFor(foundDiv);
      div      = { 'element': foundDiv, 'opts': opts };

      divs.push(div);
    }

    return divs;
  };

  DivLocator.prototype.getSelector = function(wrapper) {
    return wrapper + '[class="' + this.className + '"]';
  };

  DivLocator.prototype.optionsFor = function(div) {
    var opts     = {};
    opts.ip      = this.hasChild('ip', div);
    opts.country = this.hasChild('country', div);
    opts.coords  = this.hasChild('coords', div);

    return opts;
  };

  DivLocator.prototype.hasChild = function(name, div) {
    var selector = '.' + name;
    return $(selector, div).length !== 0;
  };

  var DivUpdater = function() {

  };

  DivUpdater.prototype.update = function(divs, meta) {
    total = divs.length;

    for (var i = 0; i < total; i++) {
      div = divs[i];
      this.updateDiv(div, meta);
    }
  };

  DivUpdater.prototype.updateDiv = function(div, meta) {
    var element = div.element;
    var opts    = div.opts;

    if (opts.ip) {
      this.updateElement($('.ip', element), meta.ip);
    }

    if (opts.country) {
      this.updateElement($('.country', element), meta.country);
    }

    if (opts.coords) {
      var coords = meta.latitude + ', ' + meta.longitude;
      this.updateElement($('.coords', element), coords);
    }
  };

  DivUpdater.prototype.updateElement = function(element, value) {
    element.text(value);
  };

  var WhatsMyIpPlugin = function() {

  };

  WhatsMyIpPlugin.prototype.run = function() {
    var ipFinder = new IpFinder();
    var self     = this;
    var promise  = ipFinder.find();

    promise.success(function(meta) {
      self.update(meta);
    });
  };

  WhatsMyIpPlugin.prototype.update = function(meta) {
    var divLocator = new DivLocator();
    var divUpdater = new DivUpdater();
    var foundDivs  = divLocator.locate();

    divUpdater.update(foundDivs, meta);
  };

  $.fn.whatsmyip = function() {
    var plugin = new WhatsMyIpPlugin();
    plugin.run();
  };

}(jQuery));
