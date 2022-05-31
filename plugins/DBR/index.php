<!--<!DOCTYPE html>-->
<!--<html>-->
<!--<body>-->
    <!-- Please visit https://www.dynamsoft.com/customer/license/trialLicense to get a trial license. -->
<!--    <script src="dist/dbr.js" data-productKeys="t0068NQAAABKiWioXIYDpG2+kaQeHV6ohmqwaDK/ZgYNCfC0peWJYSArfkoFwWnr69PSFPK6d6z2WK6/QqOz8OQOLVi2rKsY="></script>-->
<!--    <script>-->
<!--        // initializes and uses the library-->
<!--        let scanner = null;-->
<!--        (async()=>{-->
<!--            scanner = await Dynamsoft.DBR.BarcodeScanner.createInstance();-->
<!---->
<!--            let settings = await scanner.getRuntimeSettings();-->
<!--            /*-->
<!--             * 1 means true-->
<!--             * Using a percentage is easier-->
<!--             * The following code ignores 25% to each side of the video stream-->
<!--             */-->
<!--            settings.region.regionMeasuredByPercentage = 1;-->
<!--            settings.region.regionLeft = 25;-->
<!--            settings.region.regionTop = 25;-->
<!--            settings.region.regionRight = 75;-->
<!--            settings.region.regionBottom = 75;-->
<!--            await scanner.updateRuntimeSettings(settings);-->
<!---->
<!--            scanner.onFrameRead = results => {if(results.length > 0 ) console.log(results);};-->
<!--            scanner.onUnduplicatedRead = (txt, result) => {-->
<!--                let patt = new RegExp("^([0-9A-Fa-f]{2}[:-]){5}([0-9A-Fa-f]{2})|^([0-9a-fA-F]){12}$");-->
<!--                if(!patt.test(txt)) {-->
<!--                    alert("invalid MAC");-->
<!--                    return false;-->
<!--                }-->
<!---->
<!--                document.getElementById('mac').value=txt;-->
<!--                scanner.destroy();-->
<!--            };-->
<!--            await scanner.show();-->
<!--        })();-->
<!--    </script>-->
<!--</body>-->
<!--</html>-->