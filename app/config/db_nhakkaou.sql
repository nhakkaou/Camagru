CREATE TABLE `comments` (
  `user_id` int(255) NOT NULL,
  `img_id` int(255) NOT NULL,
  `Comment` varchar(255) NOT NULL,
  `cmt_time` datetime(5) DEFAULT NULL,
  `cmt_name` varchar(255) DEFAULT NULL
) ;

-- --------------------------------------------------------

--
-- Structure de la table `img`
--

CREATE TABLE `img` (
  `id_img` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `pic` varchar(255) NOT NULL,
  `date_creat` datetime NOT NULL,
  `user_name` varchar(255) DEFAULT NULL
) ;

-- --------------------------------------------------------

--
-- Structure de la table `jaimex`
--

CREATE TABLE `jaimex` (
  `user_id` int(255) NOT NULL,
  `img_id` int(255) NOT NULL,
  `usr_name` varchar(255) NOT NULL
) ;

-- --------------------------------------------------------

--
-- Structure de la table `login`
--

CREATE TABLE `login` (
  `id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `validate` tinyint(1) DEFAULT NULL,
  `profilepic` varchar(255) NOT NULL DEFAULT '../public/img/userr.gif',
  `forget_tk` varchar(255) DEFAULT NULL,
  `recieve` int(2) NOT NULL DEFAULT '1',
  `nb_post` int(255) NOT NULL DEFAULT '0'
) ;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `img`
--
ALTER TABLE `img`
  ADD PRIMARY KEY (`id_img`);

--
-- Index pour la table `jaimex`
--
ALTER TABLE `jaimex`
  ADD PRIMARY KEY (`user_id`,`img_id`);

--
-- Index pour la table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `img`
--
ALTER TABLE `img`
  MODIFY `id_img` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `login`
--
ALTER TABLE `login`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;
COMMIT;