USE dbUsers;
CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `usename` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;