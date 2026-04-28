<?php

namespace Database\Seeders;

use App\Models\FaultCode;
use Illuminate\Database\Seeder;

class FaultCodeSeeder extends Seeder
{
    public function run(): void
    {
       

        $codes = [
            // ==================== P-CODES ====================
            [
                'code' => 'P0100', 'code_type' => 'P', 'severity' => 'high',
                'title_en' => 'Mass Air Flow Circuit Malfunction',
                'title_ku' => 'کێشەی هەستیاری هەوای مەکینە',
                'description_en' => 'The MAF sensor measures how much air enters the engine. This code means the sensor signal is wrong.',
                'description_ku' => 'هەستیاری MAF بڕی هەوای مەکینە دەپێوێت. ئەم کۆدە واتە سیگناڵی هەستیار هەڵەیە.',
                'symptoms_en' => "Check Engine Light on\nCar uses more fuel than normal\nEngine hesitates when you press gas\nRough or shaky idle",
                'symptoms_ku' => "ڕووناکی پشکنینی مەکینە\nسوتەمەنی زیاتر بەکار دێت\nدوودڵی مەکینە کاتێک گاز دەدەیت",
                'possible_causes_en' => "MAF sensor is dirty or broken\nWires to the sensor are loose\nAir leak after the sensor\nSensor needs cleaning",
                'possible_causes_ku' => "هەستیاری MAF پیسە یان شکاوە\nوایەرەکانی هەستیار شلبوونەتەوە\nهەوا لێکچووە\nپێویستی بە پاککردنەوە هەیە",
                'how_to_fix_en' => "1. Open the hood and find the MAF sensor — it's on the air intake pipe between the air filter and engine.\n2. Unplug the sensor and spray it with MAF cleaner (buy from any auto shop for ~$10).\n3. Let it dry completely, plug it back in.\n4. If the code comes back, you need a new MAF sensor — costs $50-150 depending on your car.\n5. Also check the rubber pipe for cracks — any air leak can cause this code.",
                'how_to_fix_ku' => "١. هود بکەرەوە و هەستیاری MAK بدۆزەرەوە — لەسەر بۆڕی هەوای نێوان فلتەری هەوا و مەکینەیە.\n٢. هەستیارەکە ببڕەوە و بە پاککەرەوەی MAF پاکی بکەرەوە.\n٣. ڕێگە بدە بە تەواوی وشک ببێت، دووبارە بەلایەوە.\n٤. ئەگەر کۆدەکە گەڕایەوە، پێویستت بە هەستیاری نوێی MAFە.",
                'system' => 'Engine / Fuel'
            ],
            [
                'code' => 'P0113', 'code_type' => 'P', 'severity' => 'high',
                'title_en' => 'Intake Air Temperature Circuit High Input',
                'title_ku' => 'کێشەی هەستیاری پلەی هەوا',
                'description_en' => 'The IAT sensor tells the computer how hot the incoming air is. This code means the reading is too high.',
                'description_ku' => 'هەستیاری IAT پلەی گەرمی هەوای هاتوو دەپێوێت. ئەم کۆدە واتە خوێندنەوەکە زۆر بەرزە.',
                'symptoms_en' => "Check Engine Light on\nCar feels sluggish when accelerating\nUses more fuel than usual",
                'symptoms_ku' => "ڕووناکی پشکنینی مەکینە\nئۆتۆمبێل لە کاتی گازداندا سستە\nسوتەمەنی زیاتر بەکار دێت",
                'possible_causes_en' => "IAT sensor is broken\nWires to the sensor are damaged\nSensor connector is loose or dirty",
                'possible_causes_ku' => "هەستیاری IAT شکاوە\nوایەرەکانی هەستیار زیانیان پێگەیشتووە\nبەستەری هەستیار شل یان پیسە",
                'how_to_fix_en' => "1. The IAT sensor is usually on the intake pipe or air filter box — small plug with 2 wires.\n2. Unplug it and check if the connector looks clean and not rusted.\n3. If dirty, clean with electrical contact cleaner spray.\n4. Replace the sensor if cleaning doesn't work — costs about $15-40.\n5. Check the wires for cracks or exposed copper.",
                'how_to_fix_ku' => "١. هەستیاری IAT زۆربەی کات لەسەر بۆڕی هەوا یان سندووقی فلتەرە — بەستەرێکی بچووکە ٢ وایەری هەیە.\n٢. بیبڕەوە و ببینە بەستەرەکە پاکە و ژەنگاوی نەبووە.\n٣. ئەگەر پیسە بە سپرەی پاککەرەوە پاکی بکەرەوە.\n٤. هەستیارەکە بگۆڕە ئەگەر پاککردنەوە چاکی نەکرد — نرخەکەی ١٥-٤٠ دۆلارە.",
                'system' => 'Engine / Air Intake'
            ],
            [
                'code' => 'P0171', 'code_type' => 'P', 'severity' => 'high',
                'title_en' => 'System Too Lean (Bank 1)',
                'title_ku' => 'سیستەم زۆر لاوازە',
                'description_en' => 'Too much air or not enough fuel in the mixture. The engine is running "lean" which means it could overheat and cause damage.',
                'description_ku' => 'هەوای زۆر یان سوتەمەنی کەم لە تێکەڵەکەدا. مەکینە "لاواز" کار دەکات و لەوانەیە زۆر گەرم ببێت و زیان بگەیەنێت.',
                'symptoms_en' => "Check Engine Light on\nEngine hesitates or stumbles when you press the gas\nRough idle — car shakes when stopped\nEngine might stall at stop lights",
                'symptoms_ku' => "ڕووناکی پشکنینی مەکینە\nمەکینە دەدوودڵێت کاتێک گاز دەدەیت\nبێکاری ناڕێک — ئۆتۆمبێل دەلەرزێت\nلەوانەیە مەکینە بوەستێت",
                'possible_causes_en' => "Air leak in a rubber hose somewhere\nDirty or broken MAF sensor\nClogged fuel filter\nWeak fuel pump\nHole or crack in the air intake pipe",
                'possible_causes_ku' => "دەرچوونی هەوا لە شیلانەی لاستیک\nهەستیاری MAF پیس یان شکاو\nفیلتەری سوتەمەنی گیراو\nپەمپی سوتەمەنی لاواز\nکونی بۆڕی هەوا",
                'how_to_fix_en' => "1. With the engine running, listen for a hissing sound — that's an air leak. Spray soapy water on hoses and look for bubbles.\n2. Check the big rubber pipe between air filter and engine — squeeze it and look for cracks.\n3. Clean the MAF sensor with MAF cleaner spray (see P0100 above).\n4. Replace the fuel filter if it's been more than 30,000 km — costs $20-50.\n5. If still not fixed, you may have a failing fuel pump — needs a mechanic to test fuel pressure.",
                'how_to_fix_ku' => "١. بە مەکینەی کار دەکات، گوێ بگرە بۆ دەنگی فیشە — ئەوە دەرچوونی هەوایە. ئاوی سابوون بە شیلانەکاندا بپرژێنە و ببینە بڵق دروست دەبێت.\n٢. بۆڕی لاستیکی گەورەی نێوان فلتەری هەوا و مەکینە بپشکنە — بیپەستێنە و ببینە درزی تێدایە.\n٣. هەستیاری MAF پاک بکەرەوە (P0100 ببینە).\n٤. فلتەری سوتەمەنی بگۆڕە ئەگەر زیاتر لە ٣٠ هەزار کمە — ٢٠-٥٠ دۆلار.\n٥. پەمپی سوتەمەنی لەوانەیە خراپ بووبێت — پێویستت بە میکانیکە بۆ پشکنینی پەستانی سوتەمەنی.",
                'system' => 'Fuel System'
            ],
            [
                'code' => 'P0172', 'code_type' => 'P', 'severity' => 'high',
                'title_en' => 'System Too Rich (Bank 1)',
                'title_ku' => 'سیستەم زۆر دەوڵەمەندە',
                'description_en' => 'Too much fuel in the mixture. The engine is running "rich" which wastes gas and can damage the catalytic converter.',
                'description_ku' => 'سوتەمەنی زۆر لە تێکەڵەکەدا. مەکینە "دەوڵەمەند" کار دەکات و سوتەمەنی بەفیڕۆ دەدات.',
                'symptoms_en' => "Check Engine Light on\nBlack smoke from exhaust\nStrong fuel smell\nUses way more gas than usual",
                'symptoms_ku' => "ڕووناکی پشکنینی مەکینە\nدووکەڵی ڕەش لە دەرپەڕاو\nبۆنی بەهێزی سوتەمەنی\nسوتەمەنی زۆر زیاتر بەکار دێت",
                'possible_causes_en' => "Oxygen sensor is broken\nFuel injector is stuck open and leaking\nFuel pressure is too high\nAir filter is clogged — not enough air",
                'possible_causes_ku' => "هەستیاری ئۆکسجین شکاوە\nئینجێکتەری سوتەمەنی بە کراوەیی گیرساوە و دەرچووە\nپەستانی سوتەمەنی زۆر بەرزە\nفلتەری هەوا گیراوە — هەوا کەمە",
                'how_to_fix_en' => "1. Check your air filter first — easiest fix. Pull it out and hold it up to light. If you can't see light through it, replace it ($15-30).\n2. Remove and inspect spark plugs — if they're black and smell like gas, you're running rich.\n3. The O2 sensor is likely bad — it's on the exhaust pipe under the car. Replace it ($50-100).\n4. If the problem continues, a fuel injector may be stuck open — needs a professional.",
                'how_to_fix_ku' => "١. سەرەتا فلتەری هەوا بپشکنە — ئاسانترین چارەسەر. بیهێنە دەرەوە و بەرامبەر ڕووناکی بیگرە. ئەگەر ڕووناکی پێدا ناڕوات، بیگۆڕە.\n٢. پڵگی فیشەر بپشکنە — ئەگەر ڕەشن و بۆنی سوتەمەنی دەدەن، دەوڵەمەند کار دەکەیت.\n٣. هەستیاری O2 خراپە — لەسەر بۆڕی دەرپەڕاوە لە ژێر ئۆتۆمبێل. بیگۆڕە (٥٠-١٠٠ دۆلار).\n٤. ئینجێکتەری سوتەمەنی لەوانەیە بە کراوەیی گیرسابێت — پێویستی بە پسپۆڕە.",
                'system' => 'Fuel System'
            ],
            [
                'code' => 'P0217', 'code_type' => 'P', 'severity' => 'critical',
                'title_en' => 'Engine Over Temperature',
                'title_ku' => 'زیاد گەرمی مەکینە',
                'description_en' => 'Your engine is too hot! This is serious — stop driving immediately or you will destroy the engine.',
                'description_ku' => 'مەکینەت زۆر گەرمە! ئەمە مەترسیدارە — یەکسەر ئۆتۆمبێل بوەستێنە یان مەکینەکەت تێکدەچێت.',
                'symptoms_en' => "Temperature gauge in the RED zone\nSteam coming from under the hood\nBurning smell from engine\nEngine loses power or knocks",
                'symptoms_ku' => "پێوەری پلەی گەرمی لە ناوچەی سووردایە\nهەڵم لە ژێر هودەوە\nبۆنی سووتان لە مەکینەوە\nمەکینە هێز ون دەکات",
                'possible_causes_en' => "Coolant level is low — most common!\nThermostat stuck closed\nWater pump failed\nRadiator is clogged or has a hole\nCooling fan not working\nHead gasket blown (white smoke)",
                'possible_causes_ku' => "ئاستی ئاوی مەکینە کەمە — باوترین!\nتێرمۆستات بە داخراوی گیرساوە\nپەمپی ئاو شکاوە\nڕادیەتەر گیراوە یان کونی تێدایە\nپەنکەی ساردکەرەوە کار ناکات\nسەرپۆشی سلندەر تەقیوە (دووکەڵی سپی)",
                'how_to_fix_en' => "⚠️ DO NOT OPEN THE RADIATOR CAP WHILE HOT — you will get badly burned!\n\n1. Pull over immediately and turn off the engine. Let it cool for 30+ minutes.\n2. After cool, open the hood and check the coolant reservoir — it's a white plastic tank with colored liquid inside (pink, green, or blue). There are LOW and FULL marks on the side.\n3. If the level is below LOW, add coolant or water to get you to a mechanic. Pour slowly into the reservoir — NOT the radiator cap.\n4. Look under the car — is there a puddle? Green/pink liquid means a leak. Check hoses for cracks or loose connections.\n5. If the radiator fan never turns on when engine is hot, the fan motor or fuse is bad — check fuse box.\n6. White smoke from exhaust means head gasket failure — serious repair needed ($1,000-$2,000).",
                'how_to_fix_ku' => "⚠️ سەرپۆشی ڕادیەتەر مەکەرەوە کاتێک گەرمە — بە سەختی دەسوتێیت!\n\n١. یەکسەر بکشێتە لاوە و مەکینە بکوژێنە. ٣٠+ خولەک ڕێگە بدە سارد ببێت.\n٢. دوای سارد بوون، هود بکەرەوە و دەزگای ئاوی مەکینە بپشکنە — دەزگایەکی پلاستیکی سپییە شلەی ڕەنگدار تێدایە (پەمەیی، سەوز، شین). هێڵی LOW و FULL لە لایەکە.\n٣. ئەگەر لە خوار LOW بێت، ئاو یان شلەی ساردکەرەوە زیاد بکە. بە هێواشی بڕێژە ناو دەزگاکە.\n٤. لە ژێر ئۆتۆمبێل بڕوانە — گۆمێک هەیە؟ شلەی سەوز/پەمەیی واتە دەرچوون. شیلانەکان بۆ درز یان بەستەری شل بپشکنە.\n٥. ئەگەر پەنکە هەرگیز ناخولێتەوە کاتێک مەکینە گەرمە، مۆتۆری پەنکە یان فیوز خراپە.\n٦. دووکەڵی سپی لە دەرپەڕاو واتە سەرپۆشی سلندەر تەقیوە — چاککردنەوەی گەورەیە (١٠٠٠-٢٠٠٠ دۆلار).",
                'system' => 'Engine / Cooling'
            ],
            [
                'code' => 'P0300', 'code_type' => 'P', 'severity' => 'high',
                'title_en' => 'Random/Multiple Cylinder Misfire',
                'title_ku' => 'سوتانی هەڕەمەکی لە چەندین سلندەر',
                'description_en' => 'Multiple cylinders are misfiring randomly. The engine is not firing properly and will shake noticeably.',
                'description_ku' => 'چەندین سلندەر بە هەڕەمەکی تێکدەچن. مەکینە بە باشی کار ناکات و بە شێوەیەکی بەرچاو دەلەرزێت.',
                'symptoms_en' => "Check Engine Light flashing — this means severe misfire!\nCar shakes badly, especially when stopped\nLack of power when accelerating\nHard to start the engine\nFuel smell from exhaust",
                'symptoms_ku' => "ڕووناکی پشکنینی مەکینە دەڵەسکێت — واتە سوتانی توند!\nئۆتۆمبێل بە توندی دەلەرزێت\nنەبوونی هێز لە کاتی گازدان\nبە سەختی مەکینە دەست پێدەکات\nبۆنی سوتەمەنی لە دەرپەڕاو",
                'possible_causes_en' => "Old or worn spark plugs — most common!\nBad ignition coils\nFuel quality is poor or water in fuel\nClogged fuel injectors\nVacuum leak from intake manifold",
                'possible_causes_ku' => "پڵگی فیشەری کۆن — باوترین!\nکۆیلی داگیرسان خراپە\nکوالێتی سوتەمەنی خراپە یان ئاو تێکەڵی سوتەمەنییە\nئینجێکتەری سوتەمەنی گیراوە\nدەرچوونی هەوا لە مانیفۆڵدی هاتن",
                'how_to_fix_en' => "1. Start with spark plugs — they're the #1 cause. Remove one and look: if the tip is worn down, black, or oily, replace all of them. Cost: $8-25 per plug.\n2. Check ignition coils — swap coil from cylinder 1 to cylinder 2. If the misfire follows, that coil is bad.\n3. Fill up with fresh fuel from a different gas station — bad gas causes this.\n4. Add fuel injector cleaner to your tank ($10 from any auto shop).\n5. Check for loose or cracked vacuum hoses around the engine — pinched or disconnected hoses cause misfires.\n6. If none of this works, you may have a mechanical problem (low compression) — needs a professional diagnosis.",
                'how_to_fix_ku' => "١. لە پڵگی فیشەر دەست پێبکە — هۆکاری ژمارە یەکن. یەکێکیان دەرکە و سەیر کە: ئەگەر سەرەکەی تەنک بوو، ڕەش بوو، یان چەور بوو، هەموویان بگۆڕە. نرخ: ٨-٢٥ دۆلار بۆ هەر یەک.\n٢. کۆیلی داگیرسان بپشکنە — کۆیلی سلندەر ١ بگۆڕە بۆ سلندەر ٢. ئەگەر کێشەکە شوێنی گۆڕی، ئەو کۆیلە خراپە.\n٣. سوتەمەنی نوێ لە وێستگەیەکی ترەوە بەکار بێنە — سوتەمەنی خراپ دەبێتە هۆی ئەمە.\n٤. پاککەرەوەی ئینجێکتەری سوتەمەنی بە بەنزینەکەت زیاد بکە (١٠ دۆلار).\n٥. شیلانەکانی هەوا بە دەوری مەکینەدا بپشکنە — شیلانەی پەستێنراو یان ببڕاو دەبێتە هۆی سوتان.",
                'system' => 'Engine / Ignition'
            ],
            [
                'code' => 'P0301', 'code_type' => 'P', 'severity' => 'critical',
                'title_en' => 'Cylinder 1 Misfire Detected',
                'title_ku' => 'سوتانی سلندەری ١',
                'description_en' => 'Only cylinder 1 is misfiring. The problem is specific to that one cylinder.',
                'description_ku' => 'تەنها سلندەری ١ تێکدەچێت. کێشەکە تایبەتە بەو یەک سلندەرە.',
                'symptoms_en' => "Check Engine Light flashing or on\nCar shakes at idle\nLoss of power\nMore fuel consumption",
                'symptoms_ku' => "ڕووناکی پشکنینی مەکینە دەڵەسکێت\nئۆتۆمبێل لە بێکاریدا دەلەرزێت\nلەدەستدانی هێز\nسوتەمەنی زیاتر",
                'possible_causes_en' => "Spark plug #1 is bad — most likely\nIgnition coil #1 is failing\nFuel injector #1 is clogged or leaking\nLow compression in cylinder 1\nCracked valve or piston ring in cylinder 1",
                'possible_causes_ku' => "پڵگی فیشەری ژمارە ١ خراپە — زۆرترین ئەگەر\nکۆیلی داگیرسانی ژمارە ١ تێکدەچێت\nئینجێکتەری ژمارە ١ گیراوە یان دەرچووە\nپەستانی نزم لە سلندەری ١\nڤاڵڤ یان رینگی پستۆن لە سلندەری ١ شکاوە",
                'how_to_fix_en' => "1. First, swap the spark plug from cylinder 1 with another cylinder (like cylinder 2). Clear the code, start the car. If the misfire moves to cylinder 2, it was the spark plug — replace it ($10-20).\n2. If not the plug, swap the ignition coil the same way. If misfire moves, replace that coil ($30-80).\n3. If it stays on cylinder 1, the fuel injector might be the problem. Add fuel injector cleaner first. If that doesn't help, replace injector #1 ($50-150).\n4. Worst case: low compression — white smoke from oil cap when opened means broken piston ring. Needs a mechanic.",
                'how_to_fix_ku' => "١. یەکەم، پڵگی فیشەری سلندەر ١ لەگەڵ سلندەرێکی تر (وەک سلندەر ٢) بگۆڕە. کۆدەکە بسڕەوە، مەکینە هەڵبکە. ئەگەر سوتانەکە چوو بۆ سلندەر ٢، پڵگەکە خراپ بووە — بیگۆڕە.\n٢. ئەگەر پڵگ نەبوو، کۆیلی داگیرسانیش هەمان شێوە بگۆڕە. ئەگەر سوتانەکە گواسترایەوە، ئەو کۆیلە بگۆڕە.\n٣. ئەگەر هەر لە سلندەر ١ مایەوە، پاککەرەوەی ئینجێکتەر بەکار بێنە. ئەگەر سوودی نەبوو، ئینجێکتەری #١ بگۆڕە.\n٤. خراپترین حاڵەت: پەستانی نزم — دووکەڵی سپی لە سەرپۆشی ڕۆن کاتێک دەکرێتەوە واتە رینگی پستۆن شکاوە. پێویستت بە میکانیکە.",
                'system' => 'Engine / Ignition'
            ],
                        [
                'code' => 'P0401', 'code_type' => 'P', 'severity' => 'medium',
                'title_en' => 'EGR Flow Insufficient', 'title_ku' => 'ڕێژەی EGR کەمە',
                'description_en' => 'The EGR valve sends some exhaust back into the engine to reduce emissions. Not enough exhaust is flowing.',
                'description_ku' => 'ڤاڵڤی EGR هەندێک گازی دەرپەڕاو دەنێرێتەوە بۆ کەمکردنەوەی دەرپەڕاندن. ڕێژەکەی کەمە.',
                'symptoms_en' => "Check Engine Light on\nEngine knocking under acceleration\nRough idle\nFailed emissions test",
                'symptoms_ku' => "ڕووناکی پشکنینی مەکینە\nلێدانی مەکینە\nبێکاری ناڕێک",
                'possible_causes_en' => "EGR valve clogged with carbon — very common\nEGR passages blocked\nEGR vacuum hose broken\nEGR solenoid failed",
                'possible_causes_ku' => "ڤاڵڤی EGR بە کاربۆن گیراوە\nڕێڕەوی EGR داخراوە\nشیلانەی ڤاکیووم شکاوە",
                'how_to_fix_en' => "1. Find the EGR valve — looks like a small metal mushroom on top of the engine connected to the exhaust.\n2. Tap it gently with a wrench — sometimes it's just stuck.\n3. Remove it (2-3 bolts), spray inside with carb cleaner, scrub black carbon with a wire brush.\n4. Poke a screwdriver into the passages on the engine side — they clog with carbon too.\n5. Reinstall. If code returns, replace EGR valve ($80-200).",
                'how_to_fix_ku' => "١. ڤاڵڤی EGR بدۆزەرەوە — وەک قارچکێکی کانزایی لە سەر مەکینە. بە هێواشی لێی بدە. دەریبکە و بە پاککەرەوە پاکی بکەرەوە. ئەگەر چارەسەر نەبوو، بیگۆڕە.",
                'system' => 'Emissions'
            ],
            [
                'code' => 'P0420', 'code_type' => 'P', 'severity' => 'high',
                'title_en' => 'Catalyst System Efficiency Below Threshold', 'title_ku' => 'کارایی کاتالیست نزمە',
                'description_en' => 'The catalytic converter is not cleaning exhaust properly. Can be the converter itself or something causing it to fail.',
                'description_ku' => 'کاتالیست بە باشی گازی دەرپەڕاو پاک ناکاتەوە.',
                'symptoms_en' => "Check Engine Light on\nSulfur / rotten egg smell\nPoor fuel economy\nCar sluggish at high speeds",
                'symptoms_ku' => "ڕووناکی پشکنینی مەکینە\nبۆنی گۆگرد\nسوتەمەنی خراپ",
                'possible_causes_en' => "Catalytic converter worn out (lasts 100-150k km)\nExhaust leak before converter\nO2 sensors wrong\nEngine misfire damaged converter",
                'possible_causes_ku' => "کاتالیست پیربووە\nدەرچوونی دەرپەڕاو\nهەستیاری O2 هەڵە\nسوتانی مەکینە زیانی گەیاندووە",
                'how_to_fix_en' => "⚠️ Converters are expensive ($500-2000). Try cheaper fixes first:\n1. Add catalytic converter cleaner to fuel tank ($15-25), drive a week.\n2. Check for exhaust leaks before the converter — holes cause this.\n3. Replace downstream O2 sensor ($50-100) — often fixes it.\n4. If a misfire happened before this code, fix misfires first.\n5. If converter is dead, replace it. Some cars have 2 converters.",
                'how_to_fix_ku' => "⚠️ کاتالیست گرانە. چارەسەری هەرزانتر تاقی بکە: پاککەرەوە بە سوتەمەنی زیاد بکە. بۆ دەرچوونی دەرپەڕاو بگەڕێ. هەستیاری O2 بگۆڕە. ئەگەر خراپە، بیگۆڕە.",
                'system' => 'Emissions'
            ],
            [
                'code' => 'P0442', 'code_type' => 'P', 'severity' => 'medium',
                'title_en' => 'EVAP System Small Leak Detected', 'title_ku' => 'دەرچوونی بچووکی EVAP',
                'description_en' => 'Small leak in the fuel vapor system. Does NOT affect driving — emissions issue only.',
                'description_ku' => 'دەرچوونێکی بچووک لە سیستەمی هەڵمی سوتەمەنی. کار ناکاتە سەر لێخوڕین.',
                'symptoms_en' => "Check Engine Light on\nSlight fuel smell outside\nCar drives completely fine",
                'symptoms_ku' => "ڕووناکی پشکنینی مەکینە\nکەمێک بۆنی سوتەمەنی\nئۆتۆمبێل باش دەڕوات",
                'possible_causes_en' => "Gas cap loose — #1 cause!\nGas cap seal cracked\nSmall crack in EVAP hose\nPurge valve leaking slightly",
                'possible_causes_ku' => "سەرپۆشی بەنزین شلە — هۆکاری #١\nمۆری سەرپۆش درزی تێدایە\nشیلانەی EVAP درزی تێدایە",
                'how_to_fix_en' => "1. Remove gas cap and put it back — turn until it clicks 3+ times. This fixes 80% of cases.\n2. Check cap rubber seal — if cracked, buy new cap ($15-25).\n3. Inspect small black plastic EVAP hoses near engine for cracks.\n4. If code returns, get a smoke test done ($50-100 at any mechanic).\n5. Safe to drive normally while figuring it out — won't damage anything.",
                'how_to_fix_ku' => "١. سەرپۆشی بەنزین دەربکە و دووبارە دایبخە — بیسوڕێنە تا ٣ کرتە دەکات. ٨٠٪ چارەسەر دەبێت. سەرپۆشی نوێ بکڕە ئەگەر مۆرەکەی درزی تێدایە. بە ئاسایی بڕۆ — زیان ناگەیەنێت.",
                'system' => 'EVAP System'
            ],
            [
                'code' => 'P0455', 'code_type' => 'P', 'severity' => 'medium',
                'title_en' => 'EVAP System Large Leak Detected', 'title_ku' => 'دەرچوونی گەورەی EVAP',
                'description_en' => 'A large leak in the fuel vapor system. Usually easier to find than a small leak.',
                'description_ku' => 'دەرچوونێکی گەورە لە سیستەمی هەڵمی سوتەمەنی.',
                'symptoms_en' => "Check Engine Light on\nStrong fuel smell\nSlightly worse MPG",
                'symptoms_ku' => "ڕووناکی پشکنینی مەکینە\nبۆنی بەهێزی سوتەمەنی\nسوتەمەنی کەمێک زیاتر",
                'possible_causes_en' => "Gas cap missing or completely loose\nEVAP hose has come off\nPurge valve stuck open\nCharcoal canister cracked",
                'possible_causes_ku' => "سەرپۆشی بەنزین ونە\nشیلانەی EVAP دەرچووە\nڤاڵڤی پاککەرەوە بە کراوەیی گیرساوە",
                'how_to_fix_en' => "1. Is your gas cap even there? Missing cap = this code every time. Replace ($15-25).\n2. Check under car near fuel tank — wet spots? Fuel smell? If yes, tow to mechanic.\n3. Check EVAP purge valve near engine — small cylinder with 2 hoses. With engine off, you shouldn't be able to blow through it. If you can, replace ($30-60).\n4. Look for disconnected EVAP hose — push it back on firmly.\n5. Get a smoke test if nothing is visible.",
                'how_to_fix_ku' => "١. سەرپۆشی بەنزین هەیە؟ نییە = ئەم کۆدە. سەرپۆش بکڕە. شوێنی تەڕ لە ژێر ئۆتۆمبێل بگەڕێ. ڤاڵڤی پاککەرەوە بپشکنە. تاقیکردنەوەی دووکەڵ بکە.",
                'system' => 'EVAP System'
            ],
            [
                'code' => 'P0500', 'code_type' => 'P', 'severity' => 'high',
                'title_en' => 'Vehicle Speed Sensor Malfunction', 'title_ku' => 'کێشەی هەستیاری خێرایی',
                'description_en' => 'The speed sensor is not sending correct data. Your speedometer may not work correctly.',
                'description_ku' => 'هەستیاری خێرایی داتای دروست نانێرێت. لەوانەیە خێرایی پێو کار نەکات.',
                'symptoms_en' => "Speedometer not working or erratic\nCheck Engine Light on\nTransmission shifts roughly\nCruise control not working",
                'symptoms_ku' => "خێرایی پێو کار ناکات\nڕووناکی پشکنینی مەکینە\nگێڕ گۆڕین ناڕێک\nکروز کۆنترۆڵ کار ناکات",
                'possible_causes_en' => "Faulty VSS sensor\nWiring issue\nBad instrument cluster\nTransmission problem",
                'possible_causes_ku' => "هەستیاری VSS تێکچوو\nکێشەی وایەر\nپانێڵی ئامێرەکان خراپ\nکێشەی گێڕ",
                'how_to_fix_en' => "1. Find the VSS — usually on top of the transmission or near a wheel hub. It's a small sensor with 2-3 wires.\n2. Check the wires for cuts or loose connections.\n3. Clean the sensor tip with a rag — metal shavings can stick to it.\n4. Replace the sensor if cleaning doesn't work ($25-80).\n5. If speedometer still doesn't work, the instrument cluster may be bad.",
                'how_to_fix_ku' => "١. هەستیاری VSS بدۆزەرەوە — زۆر جار لە سەر گێڕە یان لە نزیک تایە. وایەرەکان بپشکنە. سەری هەستیار پاک بکەرەوە. ئەگەر چارەسەر نەبوو، بیگۆڕە.",
                'system' => 'Engine / Transmission'
            ],

            // ==================== B-CODES ====================
            [
                'code' => 'B0001', 'code_type' => 'B', 'severity' => 'critical',
                'title_en' => 'Driver Airbag Circuit Open', 'title_ku' => 'کێشەی ئەیربەگی شۆفێر',
                'description_en' => 'The driver airbag has a broken circuit. In an accident, your airbag may NOT deploy!',
                'description_ku' => 'هێڵی ئەیربەگی شۆفێر پچڕاوە. لە ڕووداوێکدا، ئەیربەگەکەت لەوانەیە کار نەکات!',
                'symptoms_en' => "Airbag warning light on\nAirbag system disabled",
                'symptoms_ku' => "ڕووناکی ئەیربەگ\nسیستەمی ئەیربەگ ناچالاکە",
                'possible_causes_en' => "Clock spring broken (behind steering wheel)\nWiring under seat loose\nBlown fuse\nAirbag module faulty",
                'possible_causes_ku' => "سپرینگی کاتژمێر شکاوە\nوایەری ژێر کورسی شل\nفیوز تەقیوە",
                'how_to_fix_en' => "⚠️ Airbags are dangerous — can deploy accidentally. Disconnect battery and wait 30 minutes before working.\n1. Check SRS/airbag fuse in fuse box — if blown, replace ($5).\n2. Check yellow wires under driver seat — if loose, push connector together firmly.\n3. Most likely: clock spring behind steering wheel is bad — needs professional replacement ($200-400).\n4. Do NOT try to replace airbag yourself — get a pro.",
                'how_to_fix_ku' => "⚠️ ئەیربەگ مەترسیدارە. پاتری ببڕەوە و ٣٠ خولەک ڕێگە بدە. فیوز بپشکنە. وایەری ژێر کورسی توند بکە. سپرینگی کاتژمێر لەوانەیە خراپ بێت — پسپۆڕ پێویستە.",
                'system' => 'Body / SRS'
            ],
            [
                'code' => 'B0028', 'code_type' => 'B', 'severity' => 'critical',
                'title_en' => 'Passenger Airbag Circuit Low', 'title_ku' => 'کێشەی ئەیربەگی ڕێبوار',
                'description_en' => 'The passenger airbag circuit has low voltage. The passenger airbag may not work.',
                'description_ku' => 'ڤۆڵتی هێڵی ئەیربەگی ڕێبوار نزمە. ئەیربەگی ڕێبوار لەوانەیە کار نەکات.',
                'symptoms_en' => "Airbag warning light\nPassenger airbag disabled",
                'symptoms_ku' => "ڕووناکی ئەیربەگ\nئەیربەگی ڕێبوار ناچالاکە",
                'possible_causes_en' => "Seat sensor faulty\nWiring under passenger seat\nAirbag module issue\nLoose connector",
                'possible_causes_ku' => "هەستیاری کورسی تێکچوو\nوایەری ژێر کورسی\nکێشەی مۆدیولی ئەیربەگ",
                'how_to_fix_en' => "1. Check under passenger seat — there's a yellow connector. Push it together until it clicks.\n2. If something was shoved under the seat (water bottle, bag), it may have knocked the wires loose.\n3. Check SRS fuse.\n4. If wiring looks fine, seat sensor may be bad — needs professional diagnosis.",
                'how_to_fix_ku' => "١. لە ژێر کورسی ڕێبوار بگەڕێ — بەستەرێکی زەرد هەیە. پاڵی پێوە بنێ تا کرتە دەکات. ئەگەر شتێک لە ژێر کورسییە، لەوانەیە وایەری شل کردبێت. فیوز بپشکنە.",
                'system' => 'Body / SRS'
            ],
            [
                'code' => 'B0100', 'code_type' => 'B', 'severity' => 'high',
                'title_en' => 'Airbag System Fault', 'title_ku' => 'کێشەی سیستەمی ئەیربەگ',
                'description_en' => 'General airbag system malfunction. Something is wrong with the SRS system.',
                'description_ku' => 'کێشەی گشتی لە سیستەمی ئەیربەگ. شتێک لە SRS دا هەڵەیە.',
                'symptoms_en' => "Airbag warning light on\nAirbag system may not deploy",
                'symptoms_ku' => "ڕووناکی ئەیربەگ\nسیستەمی ئەیربەگ لەوانەیە کار نەکات",
                'possible_causes_en' => "Faulty clock spring\nDamaged airbag module\nWiring under seat loose\nBlown fuse\nWater damage to module",
                'possible_causes_ku' => "سپرینگی کاتژمێر تێکچوو\nمۆدیولی ئەیربەگ زیانی پێگەیشتوو\nوایەری ژێر کورسی شل\nفیوز تەقیو",
                'how_to_fix_en' => "1. Check all SRS fuses in both fuse boxes (under hood and inside car).\n2. Check yellow connectors under BOTH front seats — push firmly.\n3. Look for water damage under carpets — SRS module is often under the seat or center console.\n4. Most cases need professional scan tool to pinpoint — take to mechanic or dealer.",
                'how_to_fix_ku' => "١. هەموو فیوزەکانی SRS بپشکنە. بەستەرە زەردەکانی ژێر کورسی پێشەوە توند بکە. بۆ زیانی ئاو لە ژێر فەرش بگەڕێ. زۆربەی کات پێویستت بە پسپۆڕە بۆ دۆزینەوەی ورد.",
                'system' => 'Body / SRS'
            ],
            [
                'code' => 'B1200', 'code_type' => 'B', 'severity' => 'medium',
                'title_en' => 'Fuel Sender Circuit Open', 'title_ku' => 'کێشەی ناردەری سوتەمەنی',
                'description_en' => 'The fuel level sender in your gas tank is not working. Your gas gauge may be wrong.',
                'description_ku' => 'ناردەری ئاستی سوتەمەنی لە بەنزین دەزگا کار ناکات. پێوەری بەنزین لەوانەیە هەڵە بێت.',
                'symptoms_en' => "Fuel gauge not working or stuck\nInaccurate fuel reading\nCheck Engine Light",
                'symptoms_ku' => "پێوەری سوتەمەنی کار ناکات\nخوێندنەوەی هەڵە\nڕووناکی پشکنینی مەکینە",
                'possible_causes_en' => "Faulty fuel sender unit\nWiring issue\nInstrument cluster fault\nCorroded connector",
                'possible_causes_ku' => "یەکەی ناردەر تێکچوو\nکێشەی وایەر\nپانێڵی ئامێرەکان خراپ\nبەستەری ژەنگاوی",
                'how_to_fix_en' => "1. Your fuel sender is inside the gas tank — accessible under the rear seat or from under the car.\n2. Try adding fuel injector cleaner to the tank first — sometimes frees a stuck sender.\n3. Replacement means removing the fuel pump assembly — $150-400 including labor.\n4. If you can live with a broken gas gauge, just use your trip meter and refill every 400-500 km.",
                'how_to_fix_ku' => "١. ناردەری سوتەمەنی لە ناو بەنزین دەزگایە. پاککەرەوە تاقی بکە. گۆڕینی پێویستی بە دەرکردنی پەمپی سوتەمەنی هەیە. دەتوانیت بەبێ پێوەری بەنزینیش بڕۆیت — هەر ٤٠٠-٥٠٠ کم سوتەمەنی پڕ بکە.",
                'system' => 'Body / Instruments'
            ],
            [
                'code' => 'B1318', 'code_type' => 'B', 'severity' => 'medium',
                'title_en' => 'Battery Voltage Low', 'title_ku' => 'ڤۆڵتی پاتری نزمە',
                'description_en' => 'The battery voltage is too low. Your car may have trouble starting soon.',
                'description_ku' => 'ڤۆڵتی پاتری زۆر نزمە. لەوانەیە بەم زووانە ئۆتۆمبێلەکەت بە سەختی دەست پێبکات.',
                'symptoms_en' => "Warning lights on\nHard to start engine\nElectrical issues (lights dim, radio cuts out)\nBattery dies overnight",
                'symptoms_ku' => "ڕووناکی ئاگادارکردنەوە\nبە سەختی دەست پێدەکات\nکێشەی کارەبا\nپاتری بە درێژایی شەو کۆتایی دێت",
                'possible_causes_en' => "Weak or old battery\nAlternator not charging\nLoose or corroded battery terminals\nBelt slipping\nSomething draining battery when car is off",
                'possible_causes_ku' => "پاتری لاواز یان کۆن\nئەلتەرناتۆر بارگاوی ناکات\nسەری پاتری شل یان ژەنگاوی\nقایش دەخزێت\nشتێک پاتری بەتاڵ دەکات",
                'how_to_fix_en' => "1. Check battery terminals — are they covered in white/blue powder? Clean with wire brush and baking soda + water.\n2. Tighten the terminal clamps — they should not twist by hand.\n3. Test battery with multimeter: 12.6V = good, 12.0V = weak, below 11.8V = dead.\n4. Start the car and test again: should read 13.7-14.7V. If not, alternator is bad.\n5. If battery drains overnight, something is staying on — glovebox light? Phone charger? Get a parasitic draw test.",
                'how_to_fix_ku' => "١. سەری پاتری بپشکنە — ئەگەر پۆدری سپی/شین لەسەرە، بە فرچەی وایەر و ئاوی سۆدا پاکی بکەرەوە. سەرەکان توند بکە. بە مولتیمیتر پاتری تاقی بکەرەوە. ئەلتەرناتۆر بپشکنە — دەبێت ١٣.٧-١٤.٧ ڤۆڵت بخوێنێتەوە.",
                'system' => 'Body / Electrical'
            ],
            [
                'code' => 'B1410', 'code_type' => 'B', 'severity' => 'medium',
                'title_en' => 'Driver Door Ajar Circuit', 'title_ku' => 'کێشەی هەستیاری دەرگای شۆفێر',
                'description_en' => 'The sensor that tells if the driver door is open or closed is not working.',
                'description_ku' => 'هەستیاری کرانەوە و داخستنی دەرگای شۆفێر کار ناکات.',
                'symptoms_en' => "Door ajar light stays on\nInterior lights stay on and drain battery\nAlarm may go off randomly\nDoor may not lock properly",
                'symptoms_ku' => "ڕووناکی دەرگا ناکوژێتەوە\nڕووناکی ناوەوە ناکوژێتەوە\nئەلارم بێهۆکار دەچالاک دەبێت",
                'possible_causes_en' => "Faulty door switch\nBroken wire in door hinge area\nBody control module fault\nCorroded connector",
                'possible_causes_ku' => "سویچی دەرگا تێکچوو\nوایەری ناوچەی پەتقی دەرگا شکاو\nکۆنترۆڵی بەدی تێکچوو",
                'how_to_fix_en' => "1. Find the door switch — it's a small rubber button on the door frame. Press it a few times — sometimes it's just sticky.\n2. Spray WD-40 into the switch and press repeatedly — this fixes most sticky switches.\n3. If wires are visible between door and body, check for cracked or broken wires in the rubber boot.\n4. Replace the door switch ($15-40) — usually one screw or clip.\n5. If interior lights stay on, remove the bulb temporarily so your battery doesn't die.",
                'how_to_fix_ku' => "١. سویچی دەرگا بدۆزەرەوە — دوگمەیەکی لاستیکی بچووکە لە چوارچێوەی دەرگا. چەند جار پەنجەی پێدا بنێ. WD-40ی پێدا بپرژێنە. ئەگەر چارەسەر نەبوو، سویچەکە بگۆڕە (١٥-٤٠ دۆلار).",
                'system' => 'Body / Doors'
            ],
                        // ==================== C-CODES (Chassis) ====================
            [
                'code' => 'C0035', 'code_type' => 'C', 'severity' => 'critical',
                'title_en' => 'Left Front Wheel Speed Sensor', 'title_ku' => 'هەستیاری خێرایی تایەی پێشەوەی چەپ',
                'description_en' => 'The sensor on your left front wheel is not reading speed correctly. ABS and traction control may be disabled.',
                'description_ku' => 'هەستیاری سەر تایەی پێشەوەی چەپ خێرایی بە دروستی ناخوێنێتەوە. ABS و کۆنترۆڵی ڕاکێشان ناچالاک دەبن.',
                'symptoms_en' => "ABS warning light on\nTraction control light on\nABS may not work in emergency braking\nBrake pedal may pulse oddly",
                'symptoms_ku' => "ڕووناکی ABS\nڕووناکی کۆنترۆڵی ڕاکێشان\nABS لەوانەیە کار نەکات",
                'possible_causes_en' => "Faulty wheel speed sensor\nDamaged tone ring (metal gear behind wheel)\nBroken wire to the sensor\nDirt or metal shavings on sensor tip\nABS module fault",
                'possible_causes_ku' => "هەستیاری خێرایی تێکچوو\nڕینگی تۆن زیانی پێگەیشتوو\nوایەری هەستیار بڕاوە\nپیسی لەسەر هەستیار",
                'how_to_fix_en' => "1. The wheel speed sensor is behind the left front wheel — follow the wire from the wheel hub.\n2. Remove the sensor (usually 1 bolt) and wipe the tip clean with a rag — metal shavings stick to the magnetic tip.\n3. Check the wire for cuts, cracks, or loose connections along its path.\n4. Inspect the tone ring (visible behind the brake rotor) — if teeth are broken or missing, replace the CV axle or tone ring.\n5. Replace the sensor if cleaning doesn't work ($30-80).\n6. After replacement, drive the car — the ABS light should turn off by itself after a few minutes.",
                'how_to_fix_ku' => "١. هەستیاری خێرایی لە پشت تایەی پێشەوەی چەپە — شوێنی وایەرەکەی بکەوە. هەستیارەکە دەربکە و سەرەکەی پاک بکەرەوە — پارچە کانزایی دەمێنێتەوە بە سەری موگناتیسی. وایەرەکە بپشکنە. ئەگەر چارەسەر نەبوو، هەستیارەکە بگۆڕە.",
                'system' => 'Chassis / ABS'
            ],
            [
                'code' => 'C0040', 'code_type' => 'C', 'severity' => 'critical',
                'title_en' => 'Right Front Wheel Speed Sensor', 'title_ku' => 'هەستیاری خێرایی تایەی پێشەوەی ڕاست',
                'description_en' => 'Same as C0035 but for the right front wheel. ABS and traction control may not work.',
                'description_ku' => 'هەمان C0035 بەڵام بۆ تایەی پێشەوەی ڕاست.',
                'symptoms_en' => "ABS light on\nTraction control disabled\nBrake pedal pulses\nSpeedometer may jump",
                'symptoms_ku' => "ڕووناکی ABS\nکۆنترۆڵی ڕاکێشان ناچالاک\nپەدالی بڕێک دەلەرزێت",
                'possible_causes_en' => "Faulty sensor\nBroken wire\nDamaged reluctor ring\nDebris on sensor\nABS module issue",
                'possible_causes_ku' => "هەستیار تێکچوو\nوایەر بڕاوە\nڕینگ زیانی پێگەیشتوو\nپیسی لەسەر هەستیار",
                'how_to_fix_en' => "1. Same fix as C0035 — check the right front wheel sensor behind the wheel.\n2. Clean the sensor tip with a rag.\n3. Check the wire harness for damage.\n4. Replace sensor if needed ($30-80).\n5. The most common cause is metal debris on the magnetic sensor tip — cleaning alone often fixes it.",
                'how_to_fix_ku' => "١. هەمان چارەسەری C0035 — تایەی پێشەوەی ڕاست بپشکنە. سەری هەستیار پاک بکەرەوە. وایەرەکە بپشکنە. زۆرترین هۆکار پارچە کانزایی لەسەر سەری موگناتیسی هەستیارە — پاککردنەوە زۆر جار چارەسەر دەکات.",
                'system' => 'Chassis / ABS'
            ],
            [
                'code' => 'C1200', 'code_type' => 'C', 'severity' => 'critical',
                'title_en' => 'ABS Pump Motor Circuit Open', 'title_ku' => 'هێڵی مۆتۆری پەمپی ABS کراوە',
                'description_en' => 'The ABS pump motor circuit has a break. Your ABS system will NOT work in emergency situations.',
                'description_ku' => 'هێڵی مۆتۆری پەمپی ABS پچڕاوە. سیستەمی ABS لە حاڵەتی لەناکاودا کار ناکات.',
                'symptoms_en' => "ABS light on\nBrake pedal feels hard or different\nABS does not engage during hard braking\nGrinding or buzzing noise from ABS unit",
                'symptoms_ku' => "ڕووناکی ABS\nپەدالی بڕێک سەختە\nABS لە کاتی توند ڕاگرتندا کار ناکات\nدەنگی وڕینە لە یەکەی ABS",
                'possible_causes_en' => "Faulty ABS pump motor\nBlown ABS fuse\nWiring to pump broken\nBad ABS module\nLow brake fluid",
                'possible_causes_ku' => "مۆتۆری پەمپی ABS تێکچوو\nفیوزی ABS تەقیو\nوایەری پەمپ بڕاوە\nشلەی بڕێک کەم",
                'how_to_fix_en' => "1. Check brake fluid level first — low fluid can trigger ABS codes. Fill to MAX line ($10 for brake fluid).\n2. Find the ABS fuse (usually under hood in main fuse box, labeled ABS) — if blown, replace ($5).\n3. The ABS pump is a metal block with brake lines coming out of it, usually under the hood near the brake master cylinder. Check wires going to it.\n4. If fuses and wires are fine, the ABS pump may be bad — this is an expensive repair ($500-1500). Get a professional diagnosis before replacing.",
                'how_to_fix_ku' => "١. ئاستی شلەی بڕێک بپشکنە — شلەی کەم دەبێتە هۆی کۆدی ABS. شلە پڕ بکەرەوە. فیوزی ABS بپشکنە. پەمپی ABS لە ژێر هودە، بلۆکێکی کانزاییە بە هیڵی بڕێکەوە. وایەرەکانی بپشکنە. ئەگەر پەمپ خراپە، چاککردنەوە گرانە (٥٠٠-١٥٠٠ دۆلار).",
                'system' => 'Chassis / ABS'
            ],
            [
                'code' => 'C1222', 'code_type' => 'C', 'severity' => 'critical',
                'title_en' => 'Brake Booster Pressure Sensor', 'title_ku' => 'هەستیاری پەستانی بۆستەری بڕێک',
                'description_en' => 'The brake booster pressure sensor is faulty. Your brake pedal may feel very hard to press.',
                'description_ku' => 'هەستیاری پەستانی بۆستەری بڕێک تێکچووە. پەدالی بڕێک زۆر سەخت دەبێت.',
                'symptoms_en' => "Very hard brake pedal — difficult to stop\nABS light on\nBrake warning light\nHissing sound from brake pedal area",
                'symptoms_ku' => "پەدالی بڕێک زۆر سەختە\nڕووناکی ABS\nڕووناکی ئاگادارکردنەوەی بڕێک\nدەنگی فیشە لە ناوچەی پەدال",
                'possible_causes_en' => "Faulty pressure sensor\nVacuum leak in brake booster\nBad brake booster\nWiring issue to sensor",
                'possible_causes_ku' => "هەستیاری پەستان تێکچوو\nدەرچوونی ڤاکیووم لە بۆستەر\nبۆستەری بڕێک خراپ",
                'how_to_fix_en' => "⚠️ If your brake pedal is very hard to press, drive carefully — you need much more force to stop!\n1. With engine off, pump the brake pedal 5-6 times until hard. Then hold the pedal down and start the engine. The pedal should drop slightly. If not, the brake booster is bad.\n2. Check the vacuum hose from the brake booster to the engine — if cracked or loose, replace it ($10-20).\n3. Listen for a hissing sound near the brake pedal when pressing — that's a vacuum leak.\n4. Brake booster replacement costs $300-700 — get a professional if needed.",
                'how_to_fix_ku' => "⚠️ ئەگەر پەدالی بڕێک زۆر سەختە، بە وریایی بڕۆ — هێزی زۆرتر پێویستە بۆ ڕاگرتن! مەکینە بکوژێنە و ٥-٦ جار پەدال بپەستێنە تا سەخت دەبێت. پەدال ڕابگرە و مەکینە هەڵبکە — دەبێت کەمێک نزم ببێتەوە. شیلانەی ڤاکیووم بپشکنە.",
                'system' => 'Chassis / Brakes'
            ],
            [
                'code' => 'C1500', 'code_type' => 'C', 'severity' => 'high',
                'title_en' => 'Steering Angle Sensor', 'title_ku' => 'هەستیاری گۆشەی سەکان',
                'description_en' => 'The steering angle sensor is not working. Your stability control and traction control may be affected.',
                'description_ku' => 'هەستیاری گۆشەی سەکان کار ناکات. کۆنترۆڵی سەقامگیری و ڕاکێشان کاریگەر دەبن.',
                'symptoms_en' => "ESC/TCS light on\nSteering feels off-center\nTraction control activates unnecessarily\nSteering wheel not straight when driving straight",
                'symptoms_ku' => "ڕووناکی ESC\nسەکان ناوەند نییە\nکۆنترۆڵی ڕاکێشان بێهۆکار دەچالاک دەبێت",
                'possible_causes_en' => "Steering sensor needs calibration\nFaulty steering angle sensor\nClock spring damaged\nWiring issue\nAlignment was done without resetting sensor",
                'possible_causes_ku' => "هەستیاری سەکان پێویستی بە کالیبرەیشنە\nهەستیار تێکچوو\nسپرینگی کاتژمێر شکاو\nڕێکخستنی تایە بەبێ ڕێستکردنی هەستیار",
                'how_to_fix_en' => "1. This often happens after a wheel alignment — the sensor needs to be reset. Some cars auto-calibrate by turning the steering wheel lock-to-lock 3 times.\n2. With engine running, turn steering wheel all the way left, then all the way right, then back to center. Hold center for 5 seconds. Drive straight above 25 mph for a few minutes.\n3. If that doesn't work, a mechanic can recalibrate with a scan tool in 15 minutes ($40-80).\n4. If sensor is bad, replacement costs $150-400 including labor.",
                'how_to_fix_ku' => "١. زۆر جار دوای ڕێکخستنی تایە ڕوودەدات — هەستیار پێویستی بە ڕێستکردنە. سەکان بە تەواوی بە چەپ و ڕاست بسوڕێنە ٣ جار. بۆ ٥ چرکە لە ناوەند ڕایبگرە. بە خێرایی زیاتر لە ٤٠ کم/س بڕۆ. میکانیک دەتوانێت بە ئامێری سکان لە ١٥ خولەکدا کالیبرەیت بکات.",
                'system' => 'Chassis / Steering'
            ],
                        // ==================== U-CODES (Network) ====================
            [
                'code' => 'U0001', 'code_type' => 'U', 'severity' => 'high',
                'title_en' => 'CAN Bus Communication Error', 'title_ku' => 'هەڵەی پەیوەندی CAN باس',
                'description_en' => 'The CAN bus is the communication network between your car\'s computers. This error means modules can\'t talk to each other.',
                'description_ku' => 'CAN باس تۆڕی پەیوەندی نێوان کۆمپیوتەرەکانی ئۆتۆمبێلە. ئەم هەڵەیە واتە مۆدیولەکان ناتوانن پێکەوە قسە بکەن.',
                'symptoms_en' => "Multiple warning lights come on at once\nEngine may not start\nVarious electrical problems\nTransmission shifts oddly\nGauges stop working",
                'symptoms_ku' => "چەندین ڕووناکی ئاگادارکردنەوە پێکەوە دەردەکەون\nمەکینە لەوانەیە دەست پێنەکات\nکێشەی کارەبایی جۆراوجۆر",
                'possible_causes_en' => "Loose or corroded wiring connection\nFaulty control module\nShort circuit in wiring\nAftermarket device interfering (alarm, radio, tracker)\nWater damage to wiring",
                'possible_causes_ku' => "بەستەری وایەری شل یان ژەنگاوی\nمۆدیولی کۆنترۆڵ تێکچوو\nکورتە لێدان\nئامێری زیادکراو (ئەلارم، ڕادیۆ)\nزیانی ئاو بە وایەر",
                'how_to_fix_en' => "1. Did you recently install anything? New radio, alarm, GPS tracker? Remove it and see if codes clear — aftermarket electronics are the #1 cause of CAN errors.\n2. Check your battery — a weak battery causes voltage drops that confuse modules. Test battery and replace if needed.\n3. Check all ground wires under the hood — they're black wires bolted to the car body. Tighten any loose ones.\n4. Look for water in the car — under carpets, in the trunk. Wet wiring causes CAN errors.\n5. If nothing obvious, you need a professional with a scan tool to find which module is failing — this is not a DIY fix.",
                'how_to_fix_ku' => "١. شتێکی نوێت زیاد کردووە؟ ڕادیۆ، ئەلارم، GPS؟ لایبە و ببینە کۆدەکان دەڕۆن — ئامێری زیادکراو هۆکاری #١ی هەڵەکانی CANن. پاتری بپشکنە. وایەری زەوی توند بکە. بۆ ئاو لە ژێر فەرش بگەڕێ. ئەگەر هیچ نەبینرا، پسپۆڕ پێویستە.",
                'system' => 'Network / CAN'
            ],
            [
                'code' => 'U0100', 'code_type' => 'U', 'severity' => 'critical',
                'title_en' => 'Lost Communication with ECM/PCM', 'title_ku' => 'پەیوەندی ECM ون بووە',
                'description_en' => 'Your car\'s main computer (ECM) is not communicating. The engine may not run at all.',
                'description_ku' => 'کۆمپیوتەری سەرەکی ئۆتۆمبێل (ECM) پەیوەندی ناکات. مەکینە لەوانەیە هەر کار نەکات.',
                'symptoms_en' => "Engine won't start — cranks but no start\nNo communication with scan tool\nCheck Engine Light on\nMultiple warning lights",
                'symptoms_ku' => "مەکینە دەست پێناکات\nهیچ پەیوەندییەک نییە لەگەڵ ئامێری سکان\nڕووناکی پشکنینی مەکینە\nچەندین ڕووناکی ئاگادارکردنەوە",
                'possible_causes_en' => "Blown ECM fuse\nFaulty ECM (engine computer)\nWiring issue to ECM\nBad ground connection\nWater damage to ECM",
                'possible_causes_ku' => "فیوزی ECM تەقیو\nECM تێکچوو\nکێشەی وایەر\nپەیوەندی زەوی خراپ\nزیانی ئاو بە ECM",
                'how_to_fix_en' => "1. Check the ECM fuse first — it's in the fuse box under the hood, usually labeled ECM, ECU, or PCM. Replace if blown ($5).\n2. Disconnect the battery for 15 minutes, reconnect, try starting. This resets the ECM.\n3. If the car was jump-started recently or cables were connected backwards, the ECM may be fried — very expensive ($500-1500).\n4. Check the ECM ground wire — usually on the engine block or firewall. Clean the connection.\n5. If a fuse keeps blowing, there's a short circuit somewhere — needs professional diagnosis.",
                'how_to_fix_ku' => "١. یەکەم فیوزی ECM بپشکنە — لە سندووقی فیوز لە ژێر هود، زۆر جار ECM، ECU، یان PCM نیشان کراوە. ئەگەر تەقیوە، بیگۆڕە. پاتری بۆ ١٥ خولەک داببڕە و دووبارە بەلێوە. ئەگەر ئۆتۆمبێل بە هەڵە بەسترا، ECM لەوانەیە تێکچووبێت — زۆر گرانە.",
                'system' => 'Network / ECM'
            ],
            [
                'code' => 'U0121', 'code_type' => 'U', 'severity' => 'high',
                'title_en' => 'Lost Communication with ABS Module', 'title_ku' => 'پەیوەندی مۆدیولی ABS ون بووە',
                'description_en' => 'The ABS module is not communicating with the rest of the car. Your ABS will not work.',
                'description_ku' => 'مۆدیولی ABS پەیوەندی لەگەڵ بەشی تری ئۆتۆمبێل ناکات. ABS کار ناکات.',
                'symptoms_en' => "ABS light on\nBrake warning light may be on\nSpeedometer may stop working\nNormal brakes still work — just no ABS",
                'symptoms_ku' => "ڕووناکی ABS\nڕووناکی ئاگادارکردنەوەی بڕێک\nخێرایی پێو لەوانەیە بوەستێت\nبڕێکی ئاسایی هەر کار دەکات",
                'possible_causes_en' => "Blown ABS fuse\nFaulty ABS module\nWiring issue\nBad ground\nWater in ABS connector",
                'possible_causes_ku' => "فیوزی ABS تەقیو\nمۆدیولی ABS تێکچوو\nکێشەی وایەر\nزەوی خراپ\nئاو لە بەستەری ABS",
                'how_to_fix_en' => "1. Check ABS fuse — replace if blown.\n2. Find the ABS module — it's usually the metal block with brake lines near the brake fluid reservoir. Check the electrical connector — unplug and check for water or corrosion.\n3. Clean the connector with electrical contact cleaner, dry it, plug back in.\n4. If module is bad, replacement is expensive ($400-1000). Get it diagnosed professionally before replacing.",
                'how_to_fix_ku' => "١. فیوزی ABS بپشکنە. مۆدیولی ABS بدۆزەرەوە — بلۆکێکی کانزاییە لە نزیک دەزگای شلەی بڕێک. بەستەری کارەبایی بپشکنە — بۆ ئاو یان ژەنگ بگەڕێ. بە پاککەرەوە پاکی بکەرەوە. گۆڕینی مۆدیول گرانە — سەرەتا پسپۆڕ دەستنیشانی بکات.",
                'system' => 'Network / ABS'
            ],
            [
                'code' => 'U0140', 'code_type' => 'U', 'severity' => 'high',
                'title_en' => 'Lost Communication with Body Control Module', 'title_ku' => 'پەیوەندی BCM ون بووە',
                'description_en' => 'The Body Control Module (BCM) runs your lights, windows, locks, and wipers. It\'s not communicating.',
                'description_ku' => 'مۆدیولی کۆنترۆڵی بەدی (BCM) ڕووناکی، پەنجەرە، قوفڵ، و مسۆکەکان بەڕێوە دەبات. پەیوەندی ناکات.',
                'symptoms_en' => "Power windows not working\nDoor locks acting crazy\nLights flicker or stay on\nWipers not working\nKey fob doesn't work",
                'symptoms_ku' => "پەنجەرەکان کار ناکەن\nقوفڵەکان شێتن\nڕووناکی دەڵەسکێت\nمسۆکەکان کار ناکەن\nکلیلی دوورەوە کار ناکات",
                'possible_causes_en' => "Water damage to BCM — very common!\nBlown fuse\nWiring issue\nBCM failed\nSunroof drain clogged — water drips on BCM",
                'possible_causes_ku' => "زیانی ئاو بە BCM — زۆر باوە!\nفیوز تەقیو\nکێشەی وایەر\nBCM تێکچوو\nڕێڕەوی ئاوی سەربان گیراوە",
                'how_to_fix_en' => "1. The BCM is often under the dashboard on the driver or passenger side, or under the rear seat. Check if the carpet is wet — water damage is the #1 cause.\n2. If there's been heavy rain recently, check for damp carpets. BCM sits on the floor in many cars.\n3. Check BCM fuses — replace if blown.\n4. If wet, disconnect battery, remove BCM, dry it with a fan for 24 hours. Sometimes it comes back to life.\n5. If BCM is dead, replacement costs $300-800 and needs programming — dealer or specialist required.",
                'how_to_fix_ku' => "١. BCM زۆر جار لە ژێر داشبۆرد یان ژێر کورسی دواوەیە. ببینە فەرش تەڕە — زیانی ئاو هۆکاری #١ە. ئەگەر بارانێکی زۆر باریوە، فەرش بپشکنە. فیوزەکان بپشکنە. ئەگەر تەڕە، پاتری داببڕە، BCM دەربکە، بۆ ٢٤ کاتژمێر بە پەنکە وشکی بکەرەوە.",
                'system' => 'Network / BCM'
            ],
            [
                'code' => 'U0155', 'code_type' => 'U', 'severity' => 'high',
                'title_en' => 'Lost Communication with Instrument Cluster', 'title_ku' => 'پەیوەندی پانێڵی ئامێرەکان ون بووە',
                'description_en' => 'The instrument cluster (speedometer, gauges) is not communicating. Your dashboard may go blank.',
                'description_ku' => 'پانێڵی ئامێرەکان (خێرایی پێو، پێوەرەکان) پەیوەندی ناکات. داشبۆرد لەوانەیە تاریک ببێت.',
                'symptoms_en' => "Gauges all drop to zero\nWarning lights all come on\nNo speedometer reading\nDashboard goes completely dark\nOdometer not working",
                'symptoms_ku' => "هەموو پێوەرەکان دەچنە سفر\nهەموو ڕووناکییەکان دەردەکەون\nخێرایی پێو کار ناکات\nداشبۆرد بە تەواوی تاریک دەبێت",
                'possible_causes_en' => "Faulty instrument cluster\nWiring issue\nBlown fuse\nBad ground connection\nSoftware glitch",
                'possible_causes_ku' => "پانێڵی ئامێرەکان تێکچوو\nکێشەی وایەر\nفیوز تەقیو\nپەیوەندی زەوی خراپ\nکێشەی نەرمەکاڵا",
                'how_to_fix_en' => "1. Try the \"instrument cluster reset\" — disconnect the battery negative terminal for 15 minutes, reconnect. This reboots the cluster.\n2. Check the instrument cluster fuse in the interior fuse box — usually labeled \"GAUGE\", \"IPC\", or \"METER\".\n3. Smack the top of the dashboard firmly with your palm — sometimes a loose connection gets temporarily fixed. If it flickers on, you have a loose wire.\n4. If reset doesn't fix it and fuse is good, the cluster may need replacement ($200-600). Some cars need dealer programming.",
                'how_to_fix_ku' => "١. ڕێستکردنی پانێڵ تاقی بکە — پاتری بۆ ١٥ خولەک داببڕە و دووبارە بەلێوە. فیوزی پانێڵ بپشکنە. بە دەست بە سەر داشبۆرد بکێشە — هەندێک جار بەستەری شل کاتی چاک دەبێتەوە. ئەگەر چارەسەر نەبوو، پانێڵ پێویستی بە گۆڕینە (٢٠٠-٦٠٠ دۆلار).",
                'system' => 'Network / IPC'
            ],

            [
                'code' => 'P0401', 'code_type' => 'P', 'severity' => 'medium',
                'title_en' => 'EGR Flow Insufficient',
                'title_ku' => 'ڕێژەی EGR کەمە',
                'description_en' => 'The EGR valve sends some exhaust back into the engine to reduce emissions. This code means not enough exhaust is flowing.',
                'description_ku' => 'ڤاڵڤی EGR هەندێک گازی دەرپەڕاو دەنێرێتەوە ناو مەکینە بۆ کەمکردنەوەی دەرپەڕاندن. ئەم کۆدە واتە ڕێژەکەی کەمە.',
                'symptoms_en' => "Check Engine Light on\nEngine knocking under acceleration\nRough idle\nFailed emissions test",
                'symptoms_ku' => "ڕووناکی پشکنینی مەکینە\nلێدانی مەکینە لە کاتی گازدان\nبێکاری ناڕێک\nتێکچوونی تاقیکردنەوەی دەرپەڕاندن",
                'possible_causes_en' => "EGR valve is clogged with carbon — very common\nEGR passages inside the intake are blocked\nEGR vacuum hose is broken\nEGR solenoid failed",
                'possible_causes_ku' => "ڤاڵڤی EGR بە کاربۆن گیراوە — زۆر باوە\nڕێڕەوی EGR لە ناو مەکینەدا داخراوە\nشیلانەی ڤاکیوومی EGR شکاوە\nسۆلینۆیدی EGR تێکچووە",
                'how_to_fix_en' => "1. The EGR valve looks like a small metal mushroom on top of the engine — connected to the exhaust. Tap it gently with a wrench — sometimes it's just stuck.\n2. Remove the EGR valve (2-3 bolts), spray inside with carb cleaner, scrub away the black carbon buildup with a wire brush.\n3. While it's off, poke a screwdriver into the passages on the engine side — they often clog with carbon too.\n4. Reinstall and test. If the code comes back, replace the EGR valve ($80-200).\n5. Check the small vacuum hose going to the EGR — if cracked, replace it ($5 for hose).",
                'how_to_fix_ku' => "١. ڤاڵڤی EGR وەک قارچکێکی کانزایی بچووک لە سەر مەکینەیە — بە دەرپەڕاو بەستراوە. بە ئەنبر بە هێواشی لێی بدە — هەندێک جار تەنها گیرساوە.\n٢. ڤاڵڤەکە دەرکە (٢-٣ بۆڵت)، بە پاککەرەوە پاکی بکەرەوە، ڕەشی کاربۆن بە فرچەی وایەر بتاشرەوە.\n٣. کاتێک دەرکراوە، دەرزی لە ڕێڕەوەکانی لای مەکینە بدە — زۆر جار بە کاربۆن گیراون.\n٤. دووبارە دایبنێ و تاقی بکەرەوە. ئەگەر کۆدەکە گەڕایەوە، ڤاڵڤی EGR بگۆڕە (٨٠-٢٠٠ دۆلار).\n٥. شیلانەی ڤاکیوومی بچووک کە بۆ EGR دەڕوات بپشکنە — ئەگەر درزی تێدایە، بیگۆڕە.",
                'system' => 'Emissions'
            ],
            [
                'code' => 'P0420', 'code_type' => 'P', 'severity' => 'high',
                'title_en' => 'Catalyst System Efficiency Below Threshold',
                'title_ku' => 'کارایی کاتالیست لە خوار ئاستی پێویست',
                'description_en' => 'The catalytic converter is not cleaning exhaust properly. This can be the converter itself or something causing it to fail.',
                'description_ku' => 'کاتالیست بە باشی گازی دەرپەڕاو پاک ناکاتەوە. لەوانەیە خودی کاتالیست بێت یان شتێک وای لێبکات تێکبچێت.',
                'symptoms_en' => "Check Engine Light on\nSulfur / rotten egg smell from exhaust\nPoor fuel economy\nCar may feel sluggish at high speeds",
                'symptoms_ku' => "ڕووناکی پشکنینی مەکینە\nبۆنی گۆگرد / هێلکەی بۆگەن لە دەرپەڕاو\nسوتەمەنی خراپ\nئۆتۆمبێل لە خێرایی بەرزدا سستە",
                'possible_causes_en' => "Catalytic converter is worn out (they last 100,000-150,000 km)\nExhaust leak before the converter\nO2 sensors are giving wrong readings\nEngine misfire damaged the converter\nUsing leaded or wrong fuel",
                'possible_causes_ku' => "کاتالیست پیر بووە (١٠٠-١٥٠ هەزار کم دەمێنێتەوە)\nدەرچوونی دەرپەڕاو پێش کاتالیست\nهەستیاری O2 خوێندنەوەی هەڵە دەدات\nسوتانی مەکینە زیانی بە کاتالیست گەیاندووە\nسوتەمەنی هەڵە بەکار هاتووە",
                'how_to_fix_en' => "⚠️ Catalytic converters are expensive ($500-2000). Before replacing, try cheaper fixes:\n\n1. Add catalytic converter cleaner to your fuel tank ($15-25) — drive for a week and see if the code clears.\n2. Check for exhaust leaks first — any hole before the converter causes this code. Look under the car for rust holes in the exhaust pipe.\n3. Replace the downstream O2 sensor (after the converter) — costs $50-100 and often fixes this.\n4. If you had a misfire before this code appeared, the converter may be damaged. Replace spark plugs and fix misfires FIRST, then clear codes.\n5. If converter is truly dead, you need a new one. Some cars have 2 converters — make sure you replace the right one.",
                'how_to_fix_ku' => "⚠️ کاتالیست گرانە (٥٠٠-٢٠٠٠ دۆلار). پێش گۆڕین، چارەسەری هەرزانتر تاقی بکە:\n\n١. پاککەرەوەی کاتالیست بە بەنزین زیاد بکە (١٥-٢٥ دۆلار) — هەفتەیەک بڕۆ و ببینە کۆدەکە دەڕوات.\n٢. سەرەتا بۆ دەرچوونی دەرپەڕاو بگەڕێ — هەر کونێک پێش کاتالیست دەبێتە هۆی ئەم کۆدە. لە ژێر ئۆتۆمبێل بڕوانە بۆ کونی ژەنگاوی.\n٣. هەستیاری O2 ی دوای کاتالیست بگۆڕە — ٥٠-١٠٠ دۆلار و زۆر جار چارەسەر دەکات.\n٤. ئەگەر پێش ئەم کۆدە سوتانێک هەبوو، لەوانەیە کاتالیست زیانی پێگەیشتبێت. یەکەم پڵگی فیشەر بگۆڕە و سوتانەکان چاک بکە.\n٥. ئەگەر کاتالیست بە تەواوی خراپە، پێویستت بە نوێیە. هەندێک ئۆتۆمبێل ٢ کاتالیستیان هەیە.",
                'system' => 'Emissions'
            ],
            [
                'code' => 'P0442', 'code_type' => 'P', 'severity' => 'medium',
                'title_en' => 'EVAP System Small Leak Detected',
                'title_ku' => 'دەرچوونی بچووکی EVAP',
                'description_en' => 'A small leak in the fuel vapor system. This does NOT affect how your car drives — it\'s an emissions issue.',
                'description_ku' => 'دەرچوونێکی بچووک لە سیستەمی هەڵمی سوتەمەنی. ئەمە کار ناکاتە سەر لێخوڕینی ئۆتۆمبێلەکەت — کێشەی دەرپەڕاندنە.',
                'symptoms_en' => "Check Engine Light on\nSlight fuel smell outside the car\nNothing else — car drives fine",
                'symptoms_ku' => "ڕووناکی پشکنینی مەکینە\nکەمێک بۆنی سوتەمەنی لە دەرەوە\nهیچی تر — ئۆتۆمبێل باش دەڕوات",
                'possible_causes_en' => "Gas cap is loose — #1 cause!\nGas cap seal is cracked or missing\nSmall crack in EVAP hose\nPurge valve slightly leaking\nCharcoal canister has a tiny crack",
                'possible_causes_ku' => "سەرپۆشی بەنزین شلە — هۆکاری ژمارە ١!\nمۆری سەرپۆشی بەنزین درزی تێدایە یان ونە\nدرزی بچووک لە شیلانەی EVAP\nڤاڵڤی پاککەرەوە کەمێک دەرچووە\nقەڵەمی ڕەژوو درزی وردی تێدایە",
                'how_to_fix_en' => "1. Check your gas cap! Take it off and put it back on — turn until it clicks 3+ times. Clear the code and drive. This fixes it 80% of the time.\n2. Inspect the gas cap rubber seal — if it's cracked or missing, buy a new cap ($15-25).\n3. Look at the EVAP hoses near the engine — they're small black plastic tubes. Look for cracks or disconnected ends.\n4. If the code comes back, you may need a smoke test to find the leak — any mechanic can do this for $50-100.\n5. This code won't damage your car — you can drive normally while figuring it out.",
                'how_to_fix_ku' => "١. سەرپۆشی بەنزینەکەت بپشکنە! دەریبکە و دووبارە دایبخە — بیسوڕێنە تا ٣+ کرتە دەکات. کۆدەکە بسڕەوە و بڕۆ. ئەمە ٨٠٪ی کات چارەسەر دەکات.\n٢. مۆری لاستیکی سەرپۆشی بەنزین بپشکنە — ئەگەر درزی تێدایە یان ونە، سەرپۆشێکی نوێ بکڕە (١٥-٢٥ دۆلار).\n٣. شیلانەکانی EVAP لە نزیک مەکینە بپشکنە — بۆڕی پلاستیکی ڕەشی بچووکن. بۆ درز یان سەری جیابووەوە بگەڕێ.\n٤. ئەگەر کۆدەکە گەڕایەوە، پێویستت بە تاقیکردنەوەی دووکەڵە بۆ دۆزینەوەی دەرچوون — هەر میکانیکێک دەتوانێت بە ٥٠-١٠٠ دۆلار بیکات.\n٥. ئەم کۆدە زیان بە ئۆتۆمبێل ناگەیەنێت — دەتوانیت بە ئاسایی بڕۆیت.",
                'system' => 'EVAP System'
            ],
            [
                'code' => 'P0455', 'code_type' => 'P', 'severity' => 'medium',
                'title_en' => 'EVAP System Large Leak Detected',
                'title_ku' => 'دەرچوونی گەورەی EVAP',
                'description_en' => 'A large leak in the fuel vapor system. Usually easier to find than a small leak.',
                'description_ku' => 'دەرچوونێکی گەورە لە سیستەمی هەڵمی سوتەمەنی. زۆر جار ئاسانترە لە دەرچوونی بچووک بدۆزرێتەوە.',
                'symptoms_en' => "Check Engine Light on\nStrong fuel smell\nSlightly lower MPG",
                'symptoms_ku' => "ڕووناکی پشکنینی مەکینە\nبۆنی بەهێزی سوتەمەنی\nکەمێک کەمتر سوتەمەنی",
                'possible_causes_en' => "Gas cap is missing or completely loose\nEVAP hose has come off or split open\nPurge valve stuck open\nCharcoal canister cracked open\nFuel tank has a hole or leak",
                'possible_causes_ku' => "سەرپۆشی بەنزین ونە یان بە تەواوی شلە\nشیلانەی EVAP دەرچووە یان بە تەواوی درزیوە\nڤاڵڤی پاککەرەوە بە کراوەیی گیرساوە\nقەڵەمی ڕەژوو بە تەواوی درزیوە\nبەنزین دەزگا کونی تێدایە",
                'how_to_fix_en' => "1. Is your gas cap still there? Check immediately — missing cap causes this every time. Replace cap ($15-25).\n2. Look under the car near the fuel tank — any wet spots or dripping? Strong fuel smell means a real leak — tow to mechanic.\n3. Check the EVAP purge valve — it's near the engine, a small cylinder with 2 hoses. When the car is off, you should NOT be able to blow through it. If you can, it's stuck open — replace ($30-60).\n4. Inspect all black plastic EVAP hoses — one may have popped off. Push it back on firmly.\n5. If nothing visible, get a smoke test done.",
                'how_to_fix_ku' => "١. ئایا سەرپۆشی بەنزین هێشتا ماوە؟ یەکسەر بپشکنە — سەرپۆشی ون بوو هەموو جارێک دەبێتە هۆی ئەمە. سەرپۆش بگۆڕە (١٥-٢٥ دۆلار).\n٢. لە ژێر ئۆتۆمبێل نزیک دەزگای سوتەمەنی بڕوانە — شوێنی تەڕ یان دڵۆپە هەیە؟ بۆنی زۆری سوتەمەنی واتە دەرچوونی ڕاستەقینە.\n٣. ڤاڵڤی پاککەرەوەی EVAP بپشکنە — لە نزیک مەکینەیە، سلندەرێکی بچووکە ٢ شیلانەی هەیە. کاتێک ئۆتۆمبێل کوژاوە، نابێت بتوانیت فووی پێدا بکەیت.\n٤. هەموو شیلانە پلاستیکییەکانی EVAP بپشکنە — لەوانەیە یەکێکیان دەرچووبێت. بە توندی پاڵی پێوە بنێ.\n٥. ئەگەر هیچ دیار نییە، تاقیکردنەوەی دووکەڵ بکە.",
                'system' => 'EVAP System'
            ],
        ];

        foreach ($codes as $code) {
            FaultCode::create($code);
        }

        echo "Seeded " . count($codes) . " fault codes with how-to-fix instructions.\n";
    }
}