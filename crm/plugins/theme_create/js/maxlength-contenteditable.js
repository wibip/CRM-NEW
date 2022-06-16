function maxlengthContentEditable() {
  var editableElements = document.querySelectorAll('[contenteditable="true"]');

  var clipboardEvents = ['copy', 'paste', 'cut'];
  var keyboardEvents = ['keyup', 'keypress', 'keydown', 'blur', 'change'];

  Array.from(editableElements).forEach(function (element) {
    clipboardEvents.forEach(function (clipboardEvent) {
      element.addEventListener(clipboardEvent, clipboardEventHandler);
    });
    keyboardEvents.forEach(function (keyboardEvent) {
      element.addEventListener(keyboardEvent, generalEventKeyHandler);
    });
  });

  /**
     *callback for 'cut', 'copy' , 'paste' events
     *this function will prevent the basic behavior
      of an event if the size of the text present in the element
      plus the size of the text present in the clipboard exceeds exceeds the maxlength alowed
     * @param {any} event
     */
  function clipboardEventHandler(event) {
    // IE
    if (window.clipboardData) {
      if (window.clipboardData.getData('Text').length + this.textContent.length > this.dataset.maxLength) {
        event.preventDefault();
      }
    }
    // Chrome , Firefox
    if (event.clipboardData) {
      if (event.clipboardData.getData('Text').length + this.textContent.length > this.dataset.maxLength && event.keyCode !== 8) {
        event.preventDefault();
      }
    }
  }
  /**
     *callback for 'keyup', 'keypress', 'keydown', 'blur', 'change' events
     *this function will prevent the basic behavior
      of an event if the size of the text present in the element
      plus the size of the character typed exceeds the maxlength alowed
     * @param {any} event
     */
  function generalEventKeyHandler(event) {
    if (this.dataset.maxLength && this.textContent.length == this.dataset.maxLength && !isAllowedKeyCode(event)) {
      event.preventDefault();
    }
  }
  /**
   * Check if a keycode is allowed when max limit is reached
   * 8 : Backspace
   * 37: LeftKey
   * 38: UpKey
   * 39: RightKey
   * 40: DownKey
   * ctrlKey for control key
   * metakey for command key on mac keyboard
   * @param {any} eventKeycode
   * @returns boolean
   */
  function isAllowedKeyCode(event) {
    return event.keyCode === 8 || event.keyCode === 38 || event.keyCode === 39 || event.keyCode === 37 || event.keyCode === 40 || event.ctrlKey || event.metaKey;
  }
} 

if (!Array.from) {
  Array.from = (function () {
    var toStr = Object.prototype.toString;
    var isCallable = function (fn) {
      return typeof fn === 'function' || toStr.call(fn) === '[object Function]';
    };
    var toInteger = function (value) {
      var number = Number(value);
      if (isNaN(number)) { return 0; }
      if (number === 0 || !isFinite(number)) { return number; }
      return (number > 0 ? 1 : -1) * Math.floor(Math.abs(number));
    };
    var maxSafeInteger = Math.pow(2, 53) - 1;
    var toLength = function (value) {
      var len = toInteger(value);
      return Math.min(Math.max(len, 0), maxSafeInteger);
    };

    // The length property of the from method is 1.
    return function from(arrayLike/*, mapFn, thisArg */) {
      // 1. Let C be the this value.
      var C = this;

      // 2. Let items be ToObject(arrayLike).
      var items = Object(arrayLike);

      // 3. ReturnIfAbrupt(items).
      if (arrayLike == null) {
        throw new TypeError("Array.from requires an array-like object - not null or undefined");
      }

      // 4. If mapfn is undefined, then let mapping be false.
      var mapFn = arguments.length > 1 ? arguments[1] : void undefined;
      var T;
      if (typeof mapFn !== 'undefined') {
        // 5. else
        // 5. a If IsCallable(mapfn) is false, throw a TypeError exception.
        if (!isCallable(mapFn)) {
          throw new TypeError('Array.from: when provided, the second argument must be a function');
        }

        // 5. b. If thisArg was supplied, let T be thisArg; else let T be undefined.
        if (arguments.length > 2) {
          T = arguments[2];
        }
      }

      // 10. Let lenValue be Get(items, "length").
      // 11. Let len be ToLength(lenValue).
      var len = toLength(items.length);

      // 13. If IsConstructor(C) is true, then
      // 13. a. Let A be the result of calling the [[Construct]] internal method of C with an argument list containing the single item len.
      // 14. a. Else, Let A be ArrayCreate(len).
      var A = isCallable(C) ? Object(new C(len)) : new Array(len);

      // 16. Let k be 0.
      var k = 0;
      // 17. Repeat, while k < len… (also steps a - h)
      var kValue;
      while (k < len) {
        kValue = items[k];
        if (mapFn) {
          A[k] = typeof T === 'undefined' ? mapFn(kValue, k) : mapFn.call(T, kValue, k);
        } else {
          A[k] = kValue;
        }
        k += 1;
      }
      // 18. Let putStatus be Put(A, "length", len, true).
      A.length = len;
      // 20. Return A.
      return A;
    };
  }());
}