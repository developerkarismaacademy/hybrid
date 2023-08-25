/*
 Navicat Premium Data Transfer

 Source Server         : Local
 Source Server Type    : MySQL
 Source Server Version : 100427 (10.4.27-MariaDB)
 Source Host           : localhost:3306
 Source Schema         : u5480206_kursusonline

 Target Server Type    : MySQL
 Target Server Version : 100427 (10.4.27-MariaDB)
 File Encoding         : 65001

 Date: 03/06/2023 10:13:18
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for redeem
-- ----------------------------
DROP TABLE IF EXISTS `redeem`;
CREATE TABLE `redeem`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `redeem_code` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `course_code` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `status` int NOT NULL,
  `timestamp` varchar(75) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `user_id` int NULL DEFAULT NULL,
  `mapel_id` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `redeem_user`(`user_id` ASC) USING BTREE,
  INDEX `redeem_mapel`(`mapel_id` ASC) USING BTREE,
  CONSTRAINT `redeem_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `redeem_mapel` FOREIGN KEY (`mapel_id`) REFERENCES `mapel` (`id_mapel`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of redeem
-- ----------------------------
INSERT INTO `redeem` VALUES (1, '5604328b-54ec-11ed-a0e6-08c0eb6630ae', 'lkpka_1_5603637c-54ec-11e', 1, '1672972506', 1000, 122153);
INSERT INTO `redeem` VALUES (2, 'PRAT-1674633762', 'COURSE-CODE-75', 1, '1676628843', 1000, 122157);
INSERT INTO `redeem` VALUES (3, 'G1U1XS3QFRDS', 'meran39amb6ith9', 1, '1679275359', 1000, 122159);
INSERT INTO `redeem` VALUES (4, '7G7GP2XJUY34', 'membuylcf99w869', 1, '1679880066', 1000, 122160);
INSERT INTO `redeem` VALUES (5, 'HVZODQOAALHH', 'membuylcf99w869', 1, '1679881834', 1000, 122161);
INSERT INTO `redeem` VALUES (6, 'YFRFK240I0T9', 'membuylcf99w869', 1, '1679883361', 1000, 122162);
INSERT INTO `redeem` VALUES (7, '5J7SUDTBA46M', 'membuylcf99w869', 1, '1679883407', 1000, 122163);
INSERT INTO `redeem` VALUES (8, 'SGEI1YRTMN79', 'membuylcf99w869', 1, '1679883475', 1000, 122164);

SET FOREIGN_KEY_CHECKS = 1;
