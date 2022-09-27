-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- ホスト: localhost:8889
-- 生成日時: 2022 年 9 月 27 日 13:40
-- サーバのバージョン： 5.7.34
-- PHP のバージョン: 7.4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `bandsign`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `adminusers`
--

CREATE TABLE `adminusers` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `adminusers`
--

INSERT INTO `adminusers` (`id`, `name`, `email`, `password`, `created_at`, `updated_at`) VALUES
(1, 'hogeadmin', 'hogeadmin@gmail.com', '29f964125fe7877de9a8186e7db42cbd', '2022-09-23 09:38:44', '2022-09-23 00:34:00');

-- --------------------------------------------------------

--
-- テーブルの構造 `bandusers`
--

CREATE TABLE `bandusers` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `image` varchar(100) DEFAULT NULL,
  `biography` text,
  `genre_id` int(11) NOT NULL,
  `prefecture_id` int(11) NOT NULL,
  `city` varchar(50) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `del_flg` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `bandusers`
--

INSERT INTO `bandusers` (`id`, `name`, `email`, `password`, `image`, `biography`, `genre_id`, `prefecture_id`, `city`, `created_at`, `updated_at`, `del_flg`) VALUES
(58, '聖飢魔III', 'chugen.bass.sbv@gmail.com', '29f964125fe7877de9a8186e7db42cbd', 'zpC3hkCFbyqLtKXBeLSP4xQEEVfv8ZQiAskYHnlR.jpg', '聖飢魔II（せいきまつ、英語: SEIKIMA-II、SEIKIMA II、\r\n海外公演の際にはTHE END OF THE CENTURY）は、\r\n日本のヘヴィメタルバンド。\r\n名称は「聖なる物に飢えている悪魔がII（ふたた）び蘇る」の略とされている\r\n\r\n聖飢魔II（せいきまつ、英語: SEIKIMA-II、SEIKIMA II、\r\n海外公演の際にはTHE END OF THE CENTURY）は、\r\n日本のヘヴィメタルバンド。\r\n名称は「聖なる物に飢えている悪魔がII（ふたた）び蘇る」の略とされている\r\n\r\n聖飢魔II（せいきまつ、英語: SEIKIMA-II、SEIKIMA II、\r\n海外公演の際にはTHE END OF THE CENTURY）は、\r\n日本のヘヴィメタルバンド。\r\n名称は「聖なる物に飢えている悪魔がII（ふたた）び蘇る」の略とされている', 8, 1, '札幌市', '2022-09-19 07:40:45', '2022-09-24 21:09:50', 0),
(59, 'ONE WITH A MISSION', 'chugen.bass.sbv2@gmail.com', '5bdd41f4d48a9a002f1d5f276b764d83', '4DUvbeqpIonZTmShF65TNXks8UyntGCGcSDAalCY.jpg', '日本の5人組ロックバンドである。所属レーベルはソニー・ミュージックレコーズ。所属芸能事務所はFYD。頭はオオカミ、身体は人間という外見の究極の生命体5人で構成されるという設定である。\r\n\r\nバンド名は英語で「使命を持った男」という意味で、MWAMやマンウィズなどの略称で呼ばれる。また、その外見からオオカミバンドと俗称される事もある', 2, 1, '札幌市', '2022-09-19 07:41:11', '2022-09-24 22:19:42', 0),
(60, 'シスターチルドレン', 'chugen.bass.sbv3@gmail.com', 'b7c03da19b839febb0b3ca0857cd9cfb', 'jm4NldAoOHYuKu2X6HctoFtMdEXmOh8WbsyyCLTL.jpg', '略してシスチル。', 1, 1, '札幌市', '2022-09-19 07:41:51', '2022-09-24 22:20:55', 0),
(61, 'Y JAPAN', 'chugen.bass.sbv4@gmail.com', '3d51c474134195eefebe00ca80790246', 'ckDGNah1FyfDXf2v59RxphU5IrqvoqOIzlUW6Fjx.jpg', 'test', 1, 1, '札幌市', '2022-09-19 07:42:18', '2022-09-24 22:33:00', 0),
(62, 'いきものがっかり', 'chugen.bass.sbv5@gmail.com', '7c01d084813ceea5797cbdfd1d16a010', 'EF0siquvBJYqIowxfvuMQ9bRpqhBT0GUVuxjqEdQ.jpg', 'test', 1, 1, '札幌市', '2022-09-19 07:42:52', '2022-09-24 22:35:45', 0),
(63, 'オレンジレンチン', 'chugen.bass.sbv6@gmail.com', '88868950c91be222a228fab9ac74d211', 'Pgxt3vDJ7EDO4FxpVTvQpaShiUkbHWP31ynsJxSW.jpg', 'test', 6, 47, '札幌市', '2022-09-19 07:43:29', '2022-09-24 22:47:59', 0),
(64, 'hogeband07', 'chugen.bass.sbv7@gmail.com', '7de714622db4725b54374fb2bcce5fc4', 'no_image.jpeg', 'test', 2, 1, '札幌市', '2022-09-19 07:43:50', '2022-09-19 07:43:50', 0),
(65, 'hogeband08', 'chugen.bass.sbv8@gmail.com', 'cad16cf28682e149c57838e670ab6cfb', 'no_image.jpeg', 'テスト', 1, 2, '札幌市', '2022-09-19 07:44:22', '2022-09-19 07:44:22', 0),
(66, 'hogeband09', 'chugen.bass.sbv9@gmail.com', '85d5ae9d7ca7e3b7fe18736484ab6ccb', 'no_image.jpeg', 'テスト', 1, 1, '札幌市', '2022-09-19 07:44:46', '2022-09-19 07:44:46', 0),
(67, 'hogeband10', 'chugen.bass.sbv10@gmail.com', '246ffc8c70551df238e51472e768e67d', 'no_image.jpeg', 'test', 1, 2, '札幌市', '2022-09-19 07:45:10', '2022-09-19 07:45:10', 0),
(68, 'hogehouseeee', 'chugen.bass.sbv100@gmail.com', '2aef1daf3cbd4cc6b76166b09e69c7b3', 'no_image.jpeg', NULL, 1, 1, NULL, '2022-09-22 11:57:16', '2022-09-22 11:57:16', 0),
(70, 'hogew', 'chugen.bass.sbv111@gmail.com', 'b32c2244183296eb6b1e6d1544c2d91f', 'wZ8vLTk5NDvcZWZqGsgTcviW5cz3CiGUl69ygW67.png', NULL, 1, 1, NULL, '2022-09-23 22:26:51', '2022-09-23 22:26:51', 0);

-- --------------------------------------------------------

--
-- テーブルの構造 `contacts`
--

CREATE TABLE `contacts` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `messege` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `contacts`
--

INSERT INTO `contacts` (`id`, `name`, `email`, `messege`, `created_at`, `updated_at`) VALUES
(1, 'ダンチ2', 'chugen.bass.sbv@gmail.com', 'c\r\ncc\r\nc', '2022-09-17 00:27:07', '2022-09-17 00:27:07'),
(2, 'ダンチ2', 'chugen.bass.sbv@gmail.com', 'c\r\ncc\r\nc', '2022-09-17 00:29:23', '2022-09-17 00:29:23'),
(3, 'ダンチ2', 'chugen.bass.sbv@gmail.com', 'c\r\ncc\r\nc', '2022-09-17 00:32:58', '2022-09-17 00:32:58'),
(4, 'ダンチ2', 'chugen.bass.sbv@gmail.com', 'c\r\ncc\r\nc', '2022-09-17 00:33:51', '2022-09-17 00:33:51'),
(5, 'ダンチ2', 'chugen.bass.sbv@gmail.com', 'c\r\ncc\r\nc', '2022-09-17 00:36:09', '2022-09-17 00:36:09'),
(6, 'マックスウェル2', 'chugen.bass.sbv@gmail.com', 'ccc', '2022-09-17 00:38:21', '2022-09-17 00:38:21'),
(7, 'マックスウェル2', 'chugen.bass.sbv@gmail.com', 'mm', '2022-09-17 00:39:57', '2022-09-17 00:39:57'),
(8, 'マックスウェル2', 'chugen.bass.sbv@gmail.com', 'aa', '2022-09-17 00:46:41', '2022-09-17 00:46:41'),
(9, 'マックスウェル2', 'chugen.bass.sbv@gmail.com', 'あああ', '2022-09-17 01:26:51', '2022-09-17 01:26:51'),
(10, 'マックスウェル2', 'chugen.bass.sbv@gmail.com', 'あああ', '2022-09-17 01:28:08', '2022-09-17 01:28:08'),
(11, 'マックスウェル2', 'chugen.bass.sbv@gmail.com', 'あああ', '2022-09-17 01:29:16', '2022-09-17 01:29:16'),
(12, 'マックスウェル2', 'chugen.bass.sbv@gmail.com', 'あああ', '2022-09-17 01:31:16', '2022-09-17 01:31:16'),
(13, 'マックスウェル2', 'chugen.bass.sbv@gmail.com', 'あああ', '2022-09-17 01:32:13', '2022-09-17 01:32:13'),
(14, 'マックスウェル2', 'chugen.bass.sbv@gmail.com', 'あああ', '2022-09-17 01:33:22', '2022-09-17 01:33:22'),
(15, 'マックスウェル2', 'chugen.bass.sbv@gmail.com', 'あああ', '2022-09-17 01:34:51', '2022-09-17 01:34:51'),
(16, 'マックスウェル2', 'chugen.bass.sbv@gmail.com', 'あああ', '2022-09-17 01:56:01', '2022-09-17 01:56:01'),
(17, 'ダンチ2', 'chugen.bass.sbvvvvv@gmail.com', 'nnn', '2022-09-17 02:01:59', '2022-09-17 02:01:59'),
(18, 'マックスウェル3', 'chugen.bass.sbv@gmail.com', 'fff', '2022-09-17 02:16:42', '2022-09-17 02:16:42'),
(19, 'マックスウェル3', 'chugen.bass.sbv@gmail.com', 'fff', '2022-09-17 02:17:00', '2022-09-17 02:17:00'),
(20, 'マックスウェル2', 'chugen.bass.sbv@gmail.com', 'vvvv', '2022-09-17 02:36:02', '2022-09-17 02:36:02'),
(21, 'マックスウェル2', 'chugen.bass.sbv@gmail.com', 'xx', '2022-09-18 02:39:15', '2022-09-18 02:39:15'),
(22, 'マックスウェル2', 'chugen.bass.sbv@gmail.com', 'ww', '2022-09-19 00:39:10', '2022-09-19 00:39:10'),
(23, 'マックスウェル2', 'chugen.bass.sbv@gmail.com', 'gg', '2022-09-25 23:26:00', '2022-09-25 23:26:00');

-- --------------------------------------------------------

--
-- テーブルの構造 `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- テーブルの構造 `genres`
--

CREATE TABLE `genres` (
  `id` int(11) NOT NULL COMMENT 'id',
  `genre` varchar(50) NOT NULL COMMENT 'ジャンル'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `genres`
--

INSERT INTO `genres` (`id`, `genre`) VALUES
(1, 'ポップ'),
(2, 'ロック/オルタナティブ'),
(3, 'フォーク/ カントリー'),
(4, 'エレクトロニカ'),
(5, 'R&B/ソウル'),
(6, 'ヒップホップ/ラップ'),
(7, 'レゲエ/スカ'),
(8, 'メタル');

-- --------------------------------------------------------

--
-- テーブルの構造 `likes`
--

CREATE TABLE `likes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `likes`
--

INSERT INTO `likes` (`id`, `user_id`, `post_id`, `created_at`, `update_at`) VALUES
(21, 9, 58, '2022-09-24 19:06:32', '2022-09-24 19:06:32'),
(22, 9, 58, '2022-09-24 19:07:15', '2022-09-24 19:07:15'),
(23, 9, 58, '2022-09-24 19:08:01', '2022-09-24 19:08:01'),
(24, 9, 60, '2022-09-24 19:09:44', '2022-09-24 19:09:44'),
(25, 58, 9, '2022-09-24 19:23:44', '2022-09-24 19:23:44'),
(26, 62, 11, '2022-09-24 22:35:58', '2022-09-24 22:35:58'),
(27, 58, 19, '2022-09-25 20:50:58', '2022-09-25 20:50:58'),
(28, 58, 15, '2022-09-25 20:56:32', '2022-09-25 20:56:32'),
(29, 58, 16, '2022-09-25 21:01:07', '2022-09-25 21:01:07');

-- --------------------------------------------------------

--
-- テーブルの構造 `livehouselikes`
--

CREATE TABLE `livehouselikes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `livehouselikes`
--

INSERT INTO `livehouselikes` (`id`, `user_id`, `post_id`, `created_at`, `update_at`) VALUES
(7, 9, 58, '2022-09-24 19:49:03', '2022-09-24 19:49:03'),
(8, 9, 60, '2022-09-25 00:01:35', '2022-09-25 00:01:35'),
(9, 9, 63, '2022-09-25 22:48:38', '2022-09-25 22:48:38');

-- --------------------------------------------------------

--
-- テーブルの構造 `livehouseusers`
--

CREATE TABLE `livehouseusers` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `image` varchar(100) DEFAULT NULL,
  `biography` text,
  `postcode` varchar(50) NOT NULL,
  `prefecture_id` int(11) NOT NULL,
  `city` varchar(50) NOT NULL,
  `block` varchar(50) NOT NULL,
  `building` varchar(50) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `del_flg` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `livehouseusers`
--

INSERT INTO `livehouseusers` (`id`, `name`, `email`, `password`, `image`, `biography`, `postcode`, `prefecture_id`, `city`, `block`, `building`, `created_at`, `updated_at`, `del_flg`) VALUES
(9, 'BESSIE HALL', 'chugen.bass.sbv11@gmail.com', 'fb76116ee90da10b82079715f41b910c', 'KHI6UIrFI6pHzq1nzobLhZkWiTfIDv6GeGq9RI3y.webp', '札幌のライブハウス、ベッシーホールです。', '064-0804', 1, '札幌市中央区', '南4条西6丁目8−3', '晴ればれビル', '2022-09-19 07:46:42', '2022-09-26 18:50:09', 0),
(10, 'SOUND CRUE', 'chugen.bass.sbv12@gmail.com', '91e3eb5467f9918f4a347b71d087eeae', 'RdaFCYtQP9QKCEaAt7XWIuayFd3AGKYidcKzMYMP.gif', '北海道札幌市にあるライヴハウスで音楽シーンと音、リスナーを大切にするハコです。', '060-0041', 1, '札幌市中央区大通東', '2丁目15−1−2', NULL, '2022-09-19 08:08:14', '2022-09-26 18:53:19', 0),
(11, '高円寺HIGH', 'chugen.bass.sbv13@gmail.com', '439f270dfed566520815fe36531a868c', 'pCOetEW5rjtoppoJOyypxv23XcWNsMqaP6T1e2P8.jpg', '2008年1月オープンしたライブハウス「KOENJI HIGH」は高円寺では珍しい地下2層吹き抜けの開放的なフロア（キャパ300）、高い天井と高いステージ（幅7m×奥行4m）、バンドライブからDJ・公開生放送まで、多様なジャンルに応えるポテンシャルの高さとレコーディング品質のパワフルなサウンドが特長。ギャラリーAMPとの連動イベントも可。高円寺南口から徒歩3分、コンクリート打ち放しビル地下。', '166-0003', 13, '東京都杉並区高円寺南', '4丁目30−1', NULL, '2022-09-19 08:09:35', '2022-09-26 18:56:50', 0),
(12, '池袋 音処・手刀(チョップ)', 'chugen.bass.sbv14@gmail.com', '1668df340725e11434b3b71678727cf9', 'jbBKBeWlcEQIJ0Sx6RX6c1uNOyyvpQ4YDsglAg3S.jpg', '手刀と書いて「チョップ」と読む。池袋駅北口にある2002年オープンのライブハウス手刀のアカウントです。出演バンド、持込み企画募集して居ます 。', '171-0014', 1, '東京都豊島区池袋', '2丁目46−3', 'シーマ100 B1', '2022-09-19 08:13:00', '2022-09-26 19:02:49', 0),
(13, 'REVOLVER', 'chugen.bass.sbv15@gmail.com', 'c5a930327d510d529de636260ee0a905', '9v39wYrwl6iOlnbu2e4ETFcvzVwCDxFIkrFxufEV.jpg', '札幌円山にあるBAR＆イベントスペース「REVOLVER」のアカウントです。イベント情報を中心につぶやきます！楽しいスタッフが皆様のご来店をお待ちしております！イベント参加ご希望の方もお気軽にご連絡ください！ 札幌市中央区南1条西24丁目1-8 エスターアヴェニュービルB1F', '064-0801', 1, '札幌市中央区南', '1条西24丁目1−8', 'エスターアベニュー Ｂ１Ｆ ビル', '2022-09-19 08:14:51', '2022-09-26 19:33:49', 0),
(14, 'SPIRITUAL LOUNGE', 'chugen.bass.sbv16@gmail.com', 'd8549444ce08e72b0a6bae73799480b4', 'yp6HSJWjXUg2q6Ov2Bsm51i4gbOZWcmcLZJVejLA.jpg', '札幌のライブハウス', '060-0062', 1, '札幌市中央区南', '2西4丁目10番地', NULL, '2022-09-19 08:17:09', '2022-09-26 20:14:35', 0),
(15, '八王子papaBeat', 'chugen.bass.sbv17@gmail.com', '53756ffb0477606a9ba810b9eed39a38', 'nvXHb8DFWELTjKd7QX7u5XKoxtFdKBtw1ZjKxOL7.jpg', 'JR八王子駅北口から徒歩5分。多摩地区にある料理もお酒も楽しめるアコースティック中心のライブバーです。だけど持ち込み企画・二次会・発表会など何でも引き受けます。地元最安値。色々と相談にのります。ジャンルも不問。お気軽にご連絡を', '192-0084', 1, '東京都八王子市三崎町', '2−7', 'ヨーロービル', '2022-09-19 08:23:22', '2022-09-26 20:13:10', 0),
(16, '名古屋CLUB QUATTRO', 'chugen.bass.sbv18@gmail.com', 'b9aeb1c6d3cac73dd4232bf85b55453d', 'DWN1iRwytY7keql42mCWY8rXUMavrnD4upny2onr.jpg', '名古屋CLUB QUATTRO ... クアトロの中では1988年オープンの渋谷に続く2店めとして1989年にオープン。 パルコ東館8階になります。地下鉄をご利用ください。', '460-0008', 23, '名古屋市中区栄', '3丁目29−1', '名古屋 PARCO 東館 8・9F', '2022-09-19 08:24:22', '2022-09-26 19:44:59', 0),
(17, 'Queblick', 'chugen.bass.sbv19@gmail.com', '95bfedd749e24fa76ebb00f62c62611f', 'EXA0mU7JjqxQ33CYjmVMBY7Y3keI7ktknKU4R1H0.jpg', '福岡大名LIVE HOUSE Queblickです', '810-0041', 40, '福岡市中央区大名', '2丁目6−39', '西澤ビルB1F', '2022-09-19 08:25:41', '2022-09-26 19:48:31', 0),
(18, '246 LIVEHOUSE GABU', 'chugen.bass.sbv20@gmail.com', '8551198be4a42ee169b15f9a83b6e749', 'LAi5hpYX2wgUHtPqxwmv9rmcMocEtDAJPcbOXWQv.jpg', 'スタジオ246初のライブハウス「GABU(ガブ)」2017年8月に大阪・十三にオープン！ 大阪市内でも屈指のキャパシティー、関西トップクラスの音響システム！', '061-1353', 27, '大阪市淀川区十三本町', '1丁目7-27', 'サンポードシティビル4F', '2022-09-19 08:28:25', '2022-09-26 20:02:02', 0),
(19, 'Output', 'chugen.bass.sbv21@gmail.com', '78785cfcf72c93a3c5b20f06d9d71947', '1px56ctq4uiJP0GNL2Q51yoXkCH9Py3ZRv0lH2Uq.jpg', 'カジュアルでこじんまりとしたライブハウス。多ジャンルの音楽ライブやトークイベントが開催される。', '900-0013', 47, '那覇市牧志', '2-3-22', '髙良産業ビル', '2022-09-25 20:16:47', '2022-09-25 20:16:47', 0);

-- --------------------------------------------------------

--
-- テーブルの構造 `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- テーブルのデータのダンプ `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2022_09_23_173635_create_user_tokens_table', 1);

-- --------------------------------------------------------

--
-- テーブルの構造 `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- テーブルの構造 `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- テーブルの構造 `prefectures`
--

CREATE TABLE `prefectures` (
  `id` int(11) NOT NULL COMMENT 'id',
  `prefecture` varchar(50) NOT NULL COMMENT '所在地'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `prefectures`
--

INSERT INTO `prefectures` (`id`, `prefecture`) VALUES
(1, '北海道'),
(2, '青森県'),
(3, '岩手県'),
(4, '宮城県'),
(5, '秋田県'),
(6, '山形県'),
(7, '福島県'),
(8, '茨城県'),
(9, '栃木県'),
(10, '群馬県'),
(11, '埼玉県'),
(12, '千葉県'),
(13, '東京都'),
(14, '神奈川県'),
(15, '新潟県'),
(16, '富山県'),
(17, '石川県'),
(18, '福井県'),
(19, '山梨県'),
(20, '長野県'),
(21, '岐阜県'),
(22, '静岡県'),
(23, '愛知県'),
(24, '三重県'),
(25, '滋賀県'),
(26, '京都府'),
(27, '大阪府'),
(28, '兵庫県'),
(29, '奈良県'),
(30, '和歌山県'),
(31, '鳥取県'),
(32, '島根県'),
(33, '岡山県'),
(34, '広島県'),
(35, '山口県'),
(36, '徳島県'),
(37, '香川県'),
(38, '愛媛県'),
(39, '高知県'),
(40, '福岡県'),
(41, '佐賀県'),
(42, '長崎県'),
(43, '熊本県'),
(44, '大分県'),
(45, '宮崎県'),
(46, '鹿児島県'),
(47, '沖縄県');

-- --------------------------------------------------------

--
-- テーブルの構造 `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- テーブルの構造 `user_tokens`
--

CREATE TABLE `user_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL COMMENT 'ID',
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'トークン',
  `expire_at` datetime DEFAULT NULL COMMENT 'トークンの有効期限',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='ユーザートークン';

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `adminusers`
--
ALTER TABLE `adminusers`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `bandusers`
--
ALTER TABLE `bandusers`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- テーブルのインデックス `genres`
--
ALTER TABLE `genres`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `livehouselikes`
--
ALTER TABLE `livehouselikes`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `livehouseusers`
--
ALTER TABLE `livehouseusers`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- テーブルのインデックス `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- テーブルのインデックス `prefectures`
--
ALTER TABLE `prefectures`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- テーブルのインデックス `user_tokens`
--
ALTER TABLE `user_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_tokens_token_unique` (`token`),
  ADD KEY `user_tokens_user_id_foreign` (`user_id`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `adminusers`
--
ALTER TABLE `adminusers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- テーブルの AUTO_INCREMENT `bandusers`
--
ALTER TABLE `bandusers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- テーブルの AUTO_INCREMENT `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- テーブルの AUTO_INCREMENT `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `genres`
--
ALTER TABLE `genres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id', AUTO_INCREMENT=9;

--
-- テーブルの AUTO_INCREMENT `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- テーブルの AUTO_INCREMENT `livehouselikes`
--
ALTER TABLE `livehouselikes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- テーブルの AUTO_INCREMENT `livehouseusers`
--
ALTER TABLE `livehouseusers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- テーブルの AUTO_INCREMENT `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- テーブルの AUTO_INCREMENT `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `prefectures`
--
ALTER TABLE `prefectures`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id', AUTO_INCREMENT=48;

--
-- テーブルの AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `user_tokens`
--
ALTER TABLE `user_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID';

--
-- ダンプしたテーブルの制約
--

--
-- テーブルの制約 `user_tokens`
--
ALTER TABLE `user_tokens`
  ADD CONSTRAINT `user_tokens_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
