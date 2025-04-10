-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 13, 2025 at 06:37 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bookstore`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cartId` int(11) NOT NULL,
  `CustomerID` int(11) NOT NULL,
  `ProductID` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `CustomerID` int(11) NOT NULL,
  `FullName` varchar(100) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `PhoneNumber` varchar(15) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`CustomerID`, `FullName`, `Email`, `PhoneNumber`, `Password`, `type`) VALUES
(1, 'admin', 'admin@gmail.com', '', '$2y$10$zrPivrgq2jGRF39XnHz8KOu36oQF93sW/n7MOdXreoLh.ht5ROiTG', 1),
(2, 'customer', 'customer@gmail.com', '', '$2y$10$LPiVVMNHt9RnYBeHZWa71ecgqc3s.Or4X0S7oqjYK7n7p5gxtePKa', 0);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `CustomerID` int(11) NOT NULL,
  `fullName` varchar(100) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `products` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`products`)),
  `total_price` decimal(10,2) NOT NULL,
  `PayMode` varchar(55) DEFAULT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('Pending','Processing','Shipped','Delivered','Cancelled') DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `ProductID` int(11) NOT NULL,
  `Category` varchar(50) DEFAULT NULL,
  `AuthorName` varchar(50) DEFAULT NULL,
  `ProductName` varchar(100) DEFAULT NULL,
  `ImagePath` varchar(255) DEFAULT NULL,
  `Description` text DEFAULT NULL,
  `Price` decimal(10,2) DEFAULT NULL,
  `isAvailable` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`ProductID`, `Category`, `AuthorName`, `ProductName`, `ImagePath`, `Description`, `Price`, `isAvailable`) VALUES
(1, 'Biography and Autobiography', 'Prahlad Kakar & Rupangi Sharma', 'Adman Madman', 'assets/Biography_and_autobiography/Adman Madman by Prahlad Kakar & Rupangi Sharma.jpg', 'Adman Madman by Prahlad Kakar & Rupangi Sharma is an engaging memoir exploring advertising, creativity, and personal growth.', 450.00, 1),
(2, 'Biography and Autobiography', 'Shikha Malviya', 'Anandibai Joshee: A Life in Poems', 'assets/Biography_and_autobiography/Anandibai Joshee A Life in Poems by Shikha Malviya.jpg', 'Anandibai Joshee: A Life in Poems by Shikha Malviya poetically captures the inspiring journey of India’s first female doctor.', 399.00, 1),
(3, 'Biography and Autobiography', 'Sonu Bhasin & Dheeraj Kumar Agarwal', 'Gujarmal Modi – Sahsi Udyogpati', 'assets/Biography_and_autobiography/Gujarmal Modi – Sahsi Udyogpati by Sonu Bhasin & Dheeraj Kumar Agarwal.jpg', 'Gujarmal Modi – Sahsi Udyogpati explores the remarkable life of industrialist Gujarmal Modi and his contributions to Indian business.', 500.00, 1),
(4, 'Biography and Autobiography', 'Nico Slate', 'Indian Lives – Kamaladevi Chattopadhyay: The Art of Freedom', 'assets/Biography_and_autobiography/Indian Lives – Kamaladevi Chattopadhyay The Art of Freedom by Nico Slate.jpg', 'Indian Lives by Nico Slate details the life of Kamaladevi Chattopadhyay, a pioneering freedom fighter and social reformer.', 350.00, 1),
(5, 'Biography and Autobiography', 'Shobhaa Dé', 'Insatiable: My Hunger for Life', 'assets/Biography_and_autobiography/Insatiable My Hunger for Life by Shobhaa Dé.jpg', 'Insatiable: My Hunger for Life by Shobhaa Dé is a candid memoir reflecting on her experiences, relationships, and career.', 420.00, 1),
(6, 'Biography and Autobiography', 'A.P.J. Abdul Kalam', 'My Journey - Transforming Dreams Into Actions', 'assets/Biography_and_autobiography/MY JOURNEY - TRANSFORMING DREAMS INTO ACTIONS by apj abdul kalam.jpg', 'My Journey by A.P.J. Abdul Kalam offers personal insights into his life, struggles, and achievements.', 299.00, 1),
(7, 'Biography and Autobiography', 'Sathya Saran', 'Being Ritu: The Unforgettable Story of Ritu Nanda', 'assets/Biography_and_autobiography/Ritu Nanda by Sathya Saran.jpg', 'Being Ritu by Sathya Saran chronicles the inspiring journey of Ritu Nanda, an entrepreneur and insurance advisor.', 240.00, 1),
(8, 'Biography and Autobiography', 'Romulus Whitaker & Janaki Lenin', 'Snakes, Drugs and Rock ‘n’ Roll: My Early Years', 'assets/Biography_and_autobiography/Snakes, Drugs and Rock ‘n’ Roll My Early Years by Romulus Whitaker & Janaki Lenin.jpg', 'A thrilling autobiography exploring Whitaker’s adventures in wildlife conservation and love for reptiles.', 403.76, 1),
(9, 'Biography and Autobiography', 'Manish Gaekwad', 'The Last Courtesan: Writing My Mother’s Memoir', 'assets/Biography_and_autobiography/The Last Courtesan Writing My Mother’s Memoir by Manish Gaekwad.jpg', 'A poignant memoir delving into the life of the author’s mother, a former courtesan.', 499.00, 1),
(10, 'Biography and Autobiography', 'Damodar Padhi', 'The Scrapper’s Way', 'assets/Biography_and_autobiography/The Scrapper’s Way by Damodar Padhi.jpg', 'The Scrapper’s Way by Damodar Padhi highlights personal and professional resilience in overcoming challenges.', 599.00, 1),
(11, 'Biography and Autobiography', 'Capt. G R Gopinath', 'Udaan: Air Deccan ka Safar', 'assets/Biography_and_autobiography/Udaan Air Deccan ka Safar by Capt. G R Gopinath.jpg', 'Udaan: Air Deccan ka Safar narrates the story of Air Deccan and its impact on Indian aviation.', 350.00, 1),
(12, 'Biography and Autobiography', 'A.P.J. Abdul Kalam and Arun Tiwari', 'Wings of Fire: An Autobiography', 'assets/Biography_and_autobiography/Wings Of Fire An Autobiography by apj abdul kalam and arun tiwari.jpg', 'Wings of Fire is an inspiring autobiography of A.P.J. Abdul Kalam, India’s Missile Man.', 300.00, 1),
(13, 'Biography and Autobiography', 'Girish Karnad, Srinath Perur & Madhu Joshi', 'Ye Jeevan Khel Mein', 'assets/Biography_and_autobiography/Ye Jeevan Khel Mein by Girish Karnad, Srinath Perur & Madhu Joshi.jpg', 'An autobiographical work by Girish Karnad reflecting on his life, theater, and culture.', 450.00, 1),
(14, 'Comics', 'Collin Kelly', 'Alien Black, White & Blood', 'assets/comics/Alien Black, White & Blood by collin kelly.jpg', 'Alien Black, White & Blood is a gripping anthology featuring intense, action-packed Alien stories. Showcasing different creators, it brings fresh horror and sci-fi storytelling while exploring Xenomorph terror. With stunning black-and-white visuals and bold narratives, this volume is a must-read for fans of suspenseful, high-stakes encounters in the Alien universe.', 399.00, 1),
(15, 'Comics', 'Refrainbow', 'Boyfriends, Vol. 3', 'assets/comics/Boyfriends, Vol. 3 by refrainbow.jpg', 'Boyfriends, Vol. 3 continues the heartwarming journey of four diverse students navigating love and friendship. This installment deepens their relationships, presenting humorous and touching moments that celebrate LGBTQ+ representation. With charming artwork and an engaging storyline, it captures romance, personal growth, and the joys of young love in a delightful way.', 499.00, 1),
(16, 'Comics', 'Lambcat', 'Cursed Princess Club, Vol. 4', 'assets/comics/Cursed Princess Club, Vol. 4 by lambcat.jpg', 'Cursed Princess Club, Vol. 4 follows Gwendolyn as she embraces self-acceptance in a magical world. Facing new challenges, friendships grow stronger, and secrets unfold in this whimsical, humorous series. Blending fantasy with powerful messages of individuality, it offers a delightful journey of resilience, love, and self-discovery for readers of all ages.', 450.00, 1),
(17, 'Comics', 'Gerry Duggan', 'Falling in Love on the Path to Hell Volume One', 'assets/comics/Falling in Love on the Path to Hell Volume One by gerry duggan.jpg', 'Falling in Love on the Path to Hell tells a high-stakes tale where crime and romance collide. As the protagonists navigate danger, betrayal, and unexpected emotions, the story delivers thrilling action and intense drama. This volume captivates with its gripping narrative, offering an unforgettable blend of love and suspense.', 550.00, 1),
(18, 'Comics', 'G. Willow Wilson', 'Poison Ivy, Vol. 4 Origin of Species', 'assets/comics/Poison Ivy, Vol. 4 Origin of Species by g. willow wilson.jpg', 'Poison Ivy, Vol. 4 explores the transformation of one of DC’s most intriguing antiheroes. As Ivy struggles with identity and power, she reshapes the world through her unique vision. This volume delivers a compelling blend of eco-terrorism, intrigue, and breathtaking art, making it an essential read for fans of complex characters.', 399.00, 1),
(19, 'Comics', 'Wang Kang Cheol', 'Secret Class', 'assets/comics/secret class by Wang kang cheol.jpg', 'Secret Class is a gripping story filled with intrigue, unexpected relationships, and hidden emotions. Blending drama with deep character exploration, it delivers engaging storytelling and striking artwork. As secrets unfold, tension builds, keeping readers captivated until the last page. This volume is perfect for fans of bold, mature-themed comics.', 475.00, 1),
(20, 'Comics', 'Daniel José Older', 'Star Wars The High Republic Adventures Phase III Volume', 'assets/comics/Star Wars The High Republic Adventures Phase III Volume by daniel jose older.jpg', 'Set in the Star Wars High Republic era, this volume takes readers on a thrilling adventure filled with Jedi, dangerous conflicts, and galaxy-spanning mysteries. Featuring compelling characters and action-packed storytelling, it captures the essence of Star Wars, offering fans an exciting journey into a new and unexplored time period.', 520.00, 1),
(21, 'Comics', 'Ram V & Dan Watters', 'The One Hand and The Six Fingers', 'assets/comics/The One Hand and The Six Fingers by ram v, dan wratters.jpg', 'The One Hand and The Six Fingers is a dark, gripping tale of mystery and suspense. Blending supernatural elements with noir storytelling, it follows characters entangled in dangerous secrets. With an immersive narrative and striking visuals, this volume is a must-read for fans of thrilling and thought-provoking graphic novels.', 460.00, 1),
(22, 'Comics', 'Christopher Condon', 'Ultimate Wolverine (2025-) #1', 'assets/comics/ultimate wolverine.jpg', 'Ultimate Wolverine #1 reimagines the legendary mutant in a brand-new story, exploring his raw power, relentless nature, and deep inner struggles. With dynamic action, emotional depth, and stunning artwork, this fresh take on Wolverine’s origins and battles offers an intense and exhilarating experience for longtime fans and new readers alike.', 550.00, 1),
(23, 'Comics', 'Hope Larson', 'Very Bad at Math', 'assets/comics/Very Bad at Math by hope larson.jpg', 'Very Bad at Math is a witty and heartfelt story about overcoming fears and self-doubt. With humor and relatable moments, it follows a protagonist navigating personal challenges while discovering strengths. Hope Larson delivers charming illustrations and a touching narrative, making this a delightful read for those who enjoy uplifting and fun stories.', 399.00, 1),
(24, 'Fantasy', 'S.F. Williamson', 'A Language of Dragons', 'assets/fantasy/A Language of Dragons by s.f. williamson.jpg', 'A Language of Dragons explores ancient magic, forgotten tongues, and an epic quest. As scholars uncover secrets of dragon speech, kingdoms tremble. With breathtaking world-building, intriguing lore, and compelling characters, this fantasy novel offers an unforgettable journey into a world where words hold immense power and mythical creatures shape destinies.', 480.00, 1),
(25, 'Fantasy', 'Camilla Bruce', 'At the Bottom of the Garden', 'assets/fantasy/at the bottom of the garden by camilla bruce.jpg', 'At the Bottom of the Garden is a haunting fairy tale blending reality with eerie folklore. Mysterious creatures lurk where childhood memories fade, and dark secrets are buried. With lyrical prose and spine-chilling suspense, this novel explores the thin veil between fantasy and nightmare, leaving readers spellbound and deeply unsettled.', 510.00, 1),
(26, 'Fantasy', 'Shannon Lee', 'Breath of the Dragon', 'assets/fantasy/Breath of the dragon by shannon lee.jpg', 'Breath of the Dragon is an empowering book that blends philosophy, martial arts wisdom, and personal growth. Inspired by Bruce Lee’s teachings, it delves into strength, resilience, and transformation. With inspiring anecdotes and deep insights, this book is a must-read for those seeking inner power and wisdom through self-discovery.', 450.00, 1),
(27, 'Fantasy', 'Nnedi Okorafor', 'Death of the Author', 'assets/fantasy/Death of the Author by Nnedi okorafor.jpg', 'Death of the Author is a mind-bending, genre-defying tale exploring identity, creation, and storytelling itself. As reality blurs, a writer’s journey takes unexpected turns, challenging the boundaries between fiction and truth. With masterful prose and thought-provoking themes, this novel offers an unforgettable exploration of what it means to be human.', 495.00, 1),
(28, 'Fantasy', 'Mai Corland', 'Four Ruined Realms', 'assets/fantasy/Four Ruined Realms by mai corland.jpg', 'Four Ruined Realms is a sweeping fantasy epic filled with magic, betrayal, and war. As four shattered kingdoms fight for survival, unlikely heroes rise. With intricate political intrigue, breathtaking landscapes, and a gripping narrative, this novel takes readers on an immersive journey through a world on the brink of chaos.', 520.00, 1),
(29, 'Fantasy', 'Trishsa Tobias', 'Honeysuckle and Bone', 'assets/fantasy/Honeysuckle and Bone by trishsa tobias.jpg', 'Honeysuckle and Bone is a beautifully eerie tale weaving magic, folklore, and haunting family secrets. As the protagonist uncovers a legacy tied to dark forces, reality twists around her. With poetic storytelling and vivid imagery, this novel enchants readers, blurring the line between the natural world and supernatural mysteries.', 480.00, 1),
(30, 'Fantasy', 'Richard Matheson', 'I Am Legend', 'assets/fantasy/I Am Legend by Richard Matheson.jpg', 'I Am Legend is a chilling masterpiece of horror and survival. The last man on Earth battles against vampire-like creatures in a world overtaken by darkness. With psychological depth and gripping tension, Matheson’s novel redefines the vampire myth, delivering a haunting, thought-provoking tale of isolation, humanity, and the unknown.', 540.00, 1),
(31, 'Fantasy', 'Laurie Forest', 'The Dryad Storm', 'assets/fantasy/The Dryad Storm by laurie forest.jpg', 'The Dryad Storm is an enchanting fantasy novel filled with elemental magic, ancient forests, and a war brewing between mystical beings. As a young heroine uncovers her true power, she must decide where her loyalties lie. With breathtaking world-building and compelling characters, this novel delivers a thrilling, magical adventure.', 470.00, 1),
(32, 'Fantasy', 'Edward Underhill', 'The In-Between Bookstore', 'assets/fantasy/The In-Between Bookstore by edward underhill.jpg', 'The In-Between Bookstore is a whimsical, heartfelt fantasy about a mysterious shop bridging worlds. As a young book lover stumbles upon its secrets, they find themselves caught in a magical adventure. With charming characters, enchanting settings, and a love for stories, this novel is a dream for book enthusiasts.', 490.00, 1),
(33, 'Fantasy', 'Grady Hendrix', 'The Southern Book Club’s Guide to Slaying Vampires', 'assets/fantasy/The Southern Book Club’s Guide to Slaying Vampires by Grady Hendrix.jpg', 'The Southern Book Club’s Guide to Slaying Vampires is a thrilling, darkly humorous novel where a group of women uncovers terrifying secrets. When a mysterious stranger arrives, their peaceful community faces horrifying truths. Blending horror, humor, and strong female characters, this book offers an unforgettable vampire story with a twist.', 525.00, 1),
(34, 'Fantasy', 'Isabel Cañas', 'Vampires of El Norte', 'assets/fantasy/Vampires of El Norte by Isabel Cañas.jpg', 'Vampires of El Norte is a gripping supernatural tale set in 19th-century Mexico. As a forbidden love story unfolds amid war and dark creatures, the novel blends history, romance, and horror. With atmospheric storytelling and compelling characters, this book is a mesmerizing, spine-tingling adventure for fans of gothic fiction.', 510.00, 1),
(35, 'Fantasy', 'Claire Kohda', 'Woman, Eating', 'assets/fantasy/Woman, Eating by Claire Kohda.jpg', 'Woman, Eating is a fresh, literary take on the vampire genre, following a young half-vampire struggling with identity and hunger. As she navigates modern life, themes of isolation, culture, and self-acceptance emerge. With poetic prose and deep introspection, this novel offers a unique, haunting exploration of what it means to belong.', 480.00, 1),
(36, 'Horror', 'Paul G. Tremblay', 'Cabin at the End of the World', 'assets/horror/Cabin at the End of the World by Paul G. Tremblay.png', 'Cabin at the End of the World is a chilling thriller about a family held hostage by four strangers. As an apocalypse looms, they face an impossible choice. With intense psychological horror, gripping tension, and shocking twists, this novel explores fear, sacrifice, and the fragility of reality, leaving readers breathless.', 530.00, 1),
(37, 'Horror', 'Max Brooks', 'Devolution', 'assets/horror/Devolution by Max Brooks.png', 'Devolution is a terrifying blend of survival horror and cryptid lore. A high-tech eco-community collapses as Bigfoot-like creatures emerge from the shadows. Told through journal entries and interviews, Max Brooks delivers a gripping, unsettling tale of isolation, primal instincts, and the brutal struggle to stay alive in a world gone wrong.', 520.00, 1),
(38, 'Horror', 'Grady Hendrix', 'Horrorstör', 'assets/horror/Horrorstör by Grady Hendrix.png', 'Horrorstör is a uniquely terrifying horror-comedy set in a haunted IKEA-like furniture store. Employees working the night shift uncover eerie occurrences, leading to an escalating nightmare. Blending humor, suspense, and supernatural horror, this novel delivers a fast-paced, spine-chilling experience wrapped in a clever and creative format that mimics a store catalog.', 500.00, 1),
(39, 'Horror', 'Iain Reid', 'I’m Thinking of Ending Things', 'assets/horror/I’m Thinking of Ending Things by Iain Reid.png', 'I’m Thinking of Ending Things is a psychological thriller filled with eerie tension and existential dread. A couple’s road trip takes a disturbing turn, unraveling reality itself. With unsettling prose and shocking revelations, this novel challenges perception, sanity, and the nature of human relationships, leaving readers haunted long after finishing.', 495.00, 1),
(40, 'Horror', 'Dennis A. Mahoney', 'Our Winter Monster', 'assets/horror/Our Winter Monster by dennis a mahoney.jpg', 'Our Winter Monster is a haunting, atmospheric horror novel set in a snow-covered town plagued by an ancient terror. As paranoia grows and the monster lurks closer, survivors must confront both supernatural and human horrors. With chilling suspense, rich storytelling, and an eerie winter backdrop, this tale is truly unforgettable.', 510.00, 1),
(41, 'Horror', 'Agustina Bazterrica', 'Tender Is the Flesh', 'assets/horror/Tender Is the Flesh by Agustina Bazterrica.png', 'Tender Is the Flesh is a chilling dystopian horror novel where cannibalism becomes legal. As a man working in the meat industry begins questioning morality, he faces horrifying realities. With disturbing themes, sharp social critique, and gut-wrenching storytelling, this book explores human depravity and ethical nightmares in a terrifying future.', 535.00, 1),
(42, 'Horror', 'William Peter Blatty', 'The Exorcist', 'assets/horror/The Exorcist by william peter blatty.avif', 'The Exorcist is a horror classic that tells the terrifying story of a young girl possessed by a demon. As priests battle supernatural forces, the novel delves into faith, fear, and the nature of evil. With unforgettable imagery and chilling suspense, this tale remains one of the scariest ever written.', 560.00, 1),
(43, 'Horror', 'Stephen King', 'The Raft', 'assets/horror/The Raft by Stephen King.png', 'The Raft is a short but terrifying horror story about four college students stranded on a floating raft, stalked by an unknown entity lurking beneath the water. With claustrophobic tension, gruesome imagery, and relentless horror, this tale is a haunting example of King’s ability to turn ordinary fears into nightmares.', 480.00, 1),
(44, 'Horror', 'Scott Smith', 'The Ruins', 'assets/horror/The Ruins by Scott Smith.png', 'The Ruins is a brutal psychological horror novel about a group of tourists trapped in the Mexican jungle, tormented by an ancient, predatory force. As paranoia, desperation, and terror set in, survival becomes a horrifying ordeal. With relentless suspense and graphic horror, this novel delivers an unrelenting, nerve-shredding experience.', 525.00, 1),
(45, 'Horror', 'Lauren Beukes', 'The Shining Girls', 'assets/horror/The Shining Girls by Lauren Beukes.png', 'The Shining Girls is a genre-bending thriller where a time-traveling serial killer stalks “shining” young women across decades. When one survivor fights back, a gripping game of cat and mouse unfolds. With mind-bending twists, eerie suspense, and a strong female lead, this novel delivers a hauntingly original take on horror.', 515.00, 1),
(46, 'Mystery and Thriller', 'Adrienne Young', 'A Sea of Unspoken Things', 'assets/mystery_and_thriller/A Sea of Unspoken Things by adrienne young.jpg', 'A Sea of Unspoken Things is a suspenseful novel filled with buried secrets, haunting pasts, and mysterious disappearances. When a woman returns to her childhood home, she unravels a dark mystery that threatens everything she knows. With lyrical writing and gripping twists, this novel explores loss, deception, and the power of truth.', 520.00, 1),
(47, 'Mystery and Thriller', 'Asia Mackay', 'A Serial Killer\'s Guide to Marriage', 'assets/mystery_and_thriller/A Serial Killer\'s Guide to Marriage by asia mackay.jpg', 'A Serial Killer’s Guide to Marriage is a darkly humorous, fast-paced thriller that blends crime, suspense, and unexpected romance. A wife harbors dangerous secrets while trying to maintain a normal life. With sharp wit and thrilling tension, this novel takes readers on a wild ride through deception, love, and murder.', 500.00, 1),
(48, 'Mystery and Thriller', 'Holly Jackson', 'As Good As Dead', 'assets/mystery_and_thriller/As Good As Dead by holly jackson.jpg', 'As Good As Dead is the thrilling conclusion to the bestselling Good Girl’s Guide to Murder series. When Pip finds herself the target of a stalker, she realizes a past case may not be over. With shocking twists and heart-pounding suspense, this novel keeps readers on the edge until the end.', 550.00, 1),
(49, 'Mystery and Thriller', 'Freida McFadden', 'Frieda McFadden', 'assets/mystery_and_thriller/frieda mcfadden by Freida McFadden.jpg', 'Freida McFadden delivers another gripping psychological thriller filled with twists and mind games. This novel explores unreliable narrators, shocking betrayals, and the dark secrets people keep hidden. With unpredictable storytelling and an eerie atmosphere, McFadden takes readers on a chilling journey where nothing is as it seems.', 530.00, 1),
(50, 'Mystery and Thriller', 'Audrey J. Cole', 'Missing in Flight', 'assets/mystery_and_thriller/Missing in Flight by audrey j cole.jpg', 'Missing in Flight is a high-stakes thriller where a routine flight turns into a nightmare. When a passenger vanishes midair, an investigator uncovers a deeper conspiracy. With intense action, compelling characters, and a mystery that keeps unraveling, this novel is perfect for fans of aviation thrillers and pulse-pounding suspense.', 510.00, 1),
(51, 'Mystery and Thriller', 'Kristin Koval', 'Penitence', 'assets/mystery_and_thriller/penitence by Kristin Koval.jpg', 'Penitence is a haunting psychological thriller that delves into guilt, redemption, and hidden pasts. A woman seeking refuge in a small town soon finds herself entangled in a chilling mystery. As secrets unfold, she realizes danger is closer than she thought. With gripping tension and eerie suspense, this novel is unforgettable.', 520.00, 1),
(52, 'Mystery and Thriller', 'Carter Wilson', 'Tell Me What You Did', 'assets/mystery_and_thriller/Tell Me What You Did by carter wilson.jpg', 'Tell Me What You Did is an electrifying thriller filled with deception and psychological suspense. A chilling message forces a journalist to confront a crime from her past. As she digs deeper, lies unravel and danger looms. With unexpected twists and a gripping pace, this novel keeps readers hooked until the final revelation.', 530.00, 1),
(53, 'Mystery and Thriller', 'Kiersten Modglin', 'The Amendment', 'assets/mystery_and_thriller/The Amendment by kiersten modglin.jpg', 'The Amendment is a jaw-dropping psychological thriller exploring toxic relationships and deadly secrets. A couple’s weekend getaway turns sinister when they realize they are not alone. As trust shatters, survival becomes the only priority. With tension, manipulation, and shocking twists, this novel delivers a heart-pounding experience.', 540.00, 1),
(54, 'Mystery and Thriller', 'Melissa Larsen', 'The Lost House', 'assets/mystery_and_thriller/The Lost House by melissa larsen.jpg', 'The Lost House is a chilling mystery where an abandoned home holds dark secrets. When a group of friends enters, they uncover terrifying clues about its past. With an eerie atmosphere, shocking revelations, and suspense that builds relentlessly, this novel is a must-read for fans of gothic thrillers and haunted mysteries.', 510.00, 1),
(55, 'Mystery and Thriller', 'Daniel Kenitz', 'The Perfect Home', 'assets/mystery_and_thriller/The Perfect Home by daniel kenitz.jpg', 'The Perfect Home is a psychological thriller about a dream house that hides nightmarish secrets. A couple moves into their ideal home, only to discover unsettling truths. As paranoia sets in, they must unravel the house’s dark past. With intense suspense and psychological depth, this novel keeps readers captivated.', 520.00, 1),
(56, 'Mystery and Thriller', 'Alison Gaylin', 'We Are Watching', 'assets/mystery_and_thriller/We Are Watching by alison gaylin.jpg', 'We Are Watching is a gripping thriller where surveillance, obsession, and paranoia collide. When a woman realizes she’s being watched, she unravels a terrifying conspiracy. With masterful suspense, relentless twists, and psychological intensity, this novel forces readers to question reality. A chilling exploration of trust, privacy, and hidden dangers.', 530.00, 1),
(57, 'Philosophy', 'Bertrand Russell', 'A History of Western Philosophy', 'assets/philosophy/A History of Western Philosophy by bertrand russell.jpg', 'A History of Western Philosophy is a comprehensive analysis of philosophical thought from ancient Greece to modern times. Bertrand Russell explores major philosophers, their ideas, and how they shaped the world. With clarity and wit, this book remains an essential introduction to Western philosophical traditions and intellectual history.', 600.00, 1),
(58, 'Philosophy', 'Friedrich Nietzsche', 'Beyond Good and Evil', 'assets/philosophy/Beyond Good and Evil by friedrich nietzsche.jpg', 'Beyond Good and Evil challenges traditional moral values, urging readers to rethink truth, morality, and human nature. Friedrich Nietzsche’s provocative insights dissect philosophical assumptions, encouraging independent thought. This masterpiece questions conventional wisdom and explores the complexities of human will, power, and perspective.', 480.00, 1),
(59, 'Philosophy', 'Immanuel Kant', 'Critique of Pure Reason', 'assets/philosophy/Critique of Pure Reason by immanuel kant.jpg', 'Critique of Pure Reason is Immanuel Kant’s groundbreaking work on metaphysics and epistemology. It examines human perception, knowledge, and the limits of reason. Kant introduces the concept of a priori knowledge, shaping modern philosophy and influencing debates on reality, consciousness, and the nature of existence.', 620.00, 1),
(60, 'Philosophy', 'Seneca', 'Letter from a Stoic', 'assets/philosophy/letter from a stoic by senecca.jpg', 'Letter from a Stoic offers timeless wisdom on resilience, virtue, and self-discipline. Seneca’s letters provide philosophical guidance on living a meaningful life, handling adversity, and achieving inner peace. His Stoic teachings remain relevant, offering practical insights into personal growth and emotional strength.', 450.00, 1),
(61, 'Philosophy', 'Viktor E. Frankl', 'Man’s Search for Meaning', 'assets/philosophy/Man’s Search for Meaning by victor E. frankal.jpg', 'Man’s Search for Meaning explores Viktor Frankl’s experiences in Nazi concentration camps and his psychological insights on finding purpose. Combining existential philosophy with logotherapy, this book highlights resilience, hope, and the power of meaning in life’s most difficult moments.', 490.00, 1),
(62, 'Philosophy', 'Marcus Aurelius', 'Meditations', 'assets/philosophy/Meditations by maecus aurelius.jpg', 'Meditations is Marcus Aurelius’ personal reflections on Stoicism, wisdom, and leadership. Written as a guide for self-improvement, it offers profound insights on resilience, virtue, and mindfulness. His thoughts remain a cornerstone of Stoic philosophy and personal development.', 470.00, 1),
(63, 'Philosophy', 'Lao Tzu', 'Tao Te Ching', 'assets/philosophy/Tao Te Ching by lao tzu.jpg', 'Tao Te Ching is a foundational text of Taoist philosophy, emphasizing harmony, balance, and simplicity. Lao Tzu’s poetic verses explore the nature of existence, wisdom, and leadership. This timeless classic offers profound spiritual guidance and a path to inner peace.', 460.00, 1),
(64, 'Philosophy', 'Sun Tzu', 'The Art of War', 'assets/philosophy/The Art of War by sun tzu.jpg', 'The Art of War is an ancient Chinese military treatise by Sun Tzu. It provides strategies on warfare, leadership, and strategic thinking, applicable beyond battlefields to business, politics, and life. This timeless guide offers wisdom on victory, discipline, and adaptability.', 500.00, 1),
(65, 'Philosophy', 'Aristotle', 'The Nicomachean Ethics', 'assets/philosophy/The Nicomachean Ethics by aristotle.jpg', 'The Nicomachean Ethics explores Aristotle’s thoughts on virtue, happiness, and moral philosophy. He examines human purpose, ethical living, and the pursuit of the good life. This foundational text remains essential for understanding classical philosophy and ethical reasoning.', 520.00, 1),
(66, 'Philosophy', 'Niccolò Machiavelli', 'The Prince', 'assets/philosophy/the prince by Niccolò Machiavelli.jpg', 'The Prince is a political treatise on power, leadership, and strategy. Niccolò Machiavelli’s work explores pragmatic governance, manipulation, and the realities of ruling. His insights on ambition, deception, and control continue to influence politics and leadership strategies.', 480.00, 1),
(67, 'Philosophy', 'Plato', 'The Republic', 'assets/philosophy/The Republic by plato.jpg', 'The Republic is Plato’s philosophical dialogue on justice, politics, and the ideal state. He explores the nature of governance, morality, and education, introducing the concept of philosopher-kings. This classic work continues to shape political philosophy and discussions on justice.', 540.00, 1),
(68, 'Philosophy', 'Albert Camus', 'The Stranger', 'assets/philosophy/The Stranger by albert camus.jpg', 'The Stranger is a masterpiece of existentialist philosophy, exploring absurdity, fate, and alienation. Albert Camus’ novel follows Meursault, a detached protagonist confronting life’s meaninglessness. This thought-provoking work challenges conventional morality and explores human indifference.', 480.00, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cartId`),
  ADD KEY `fk_cart_customer` (`CustomerID`),
  ADD KEY `fk_cart_product` (`ProductID`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`CustomerID`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `CustomerID` (`CustomerID`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`ProductID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cartId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `CustomerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `ProductID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `fk_cart_customer` FOREIGN KEY (`CustomerID`) REFERENCES `customer` (`CustomerID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_cart_product` FOREIGN KEY (`ProductID`) REFERENCES `products` (`ProductID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`CustomerID`) REFERENCES `customer` (`CustomerID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
