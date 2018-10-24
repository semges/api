[33mcommit 4f1d0d6df2366c2b377e7e2d970936c6e530470d[m[33m ([m[1;36mHEAD -> [m[1;32mmaster[m[33m, [m[1;31morigin/master[m[33m)[m
Author: semges <aubin.kacyem.it@gmail.com>
Date:   Thu Aug 23 01:25:17 2018 +0100

    Configuration de Doctrine user Provider et installation du Bundle LexikJWTAuthenticationBundle

[1mdiff --git a/src/Command/CreateUserCommand.php b/src/Command/CreateUserCommand.php[m
[1mnew file mode 100644[m
[1mindex 0000000..6bb0bc4[m
[1m--- /dev/null[m
[1m+++ b/src/Command/CreateUserCommand.php[m
[36m@@ -0,0 +1,107 @@[m
[32m+[m[32m<?php[m
[32m+[m
[32m+[m[32mnamespace App\Command;[m
[32m+[m
[32m+[m[32muse Symfony\Component\Console\Input\InputArgument;[m
[32m+[m[32muse Symfony\Component\Console\Input\InputInterface;[m
[32m+[m[32muse Symfony\Component\Console\Input\InputOption;[m
[32m+[m[32muse Symfony\Component\Console\Output\OutputInterface;[m
[32m+[m[32muse Symfony\Component\Console\Question\Question;[m
[32m+[m[32muse Symfony\Component\Console\Command\Command;[m
[32m+[m[32muse Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;[m
[32m+[m[32muse Doctrine\ORM\EntityManagerInterface;[m
[32m+[m[32muse App\Entity\Utilisateur;[m
[32m+[m[32muse Symfony\Component\Validator\Validator\ValidatorInterface;[m
[32m+[m
[32m+[m[32mclass CreateUserCommand extends Command[m
[32m+[m[32m{[m
[32m+[m[32m    private $em;[m
[32m+[m
[32m+[m[32m    private $passwordEncoder;[m
[32m+[m
[32m+[m[32m    private $validator;[m
[32m+[m
[32m+[m[32m    public function __construct(UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $em, ValidatorInterface $validator)[m
[32m+[m[32m    {[m
[32m+[m[32m        $this->em = $em;[m
[32m+[m[32m        $this->passwordEncoder = $passwordEncoder;[m
[32m+[m[32m        $this->validator = $validator;[m
[32m+[m
[32m+[m[32m        parent::__construct();[m
[32m+[m[32m    }[m
[32m+[m
[32m+[m[32m    protected function configure()[m
[32m+[m[32m    {[m
[32m+[m[32m        $this[m
[32m+[m[32m            ->setName('app:create-user')[m
[32m+[m[32m            ->setDescription('Create a user.')[m
[32m+[m[32m            ->setDefinition(array([m
[32m+[m[32m                new InputArgument('username', InputArgument::REQUIRED, 'The username'),[m
[32m+[m[32m                new InputArgument('email', InputArgument::REQUIRED, 'The email'),[m
[32m+[m[32m                new InputArgument('password', InputArgument::REQUIRED, 'The password'),[m
[32m+[m[32m            ))[m
[32m+[m[32m            ;[m
[32m+[m[32m    }[m
[32m+[m
[32m+[m[32m    /**[m
[32m+[m[32m     *      * {@inheritdoc}[m
[32m+[m[32m     *           */[m
[32m+[m[32m    protected function execute(InputInterface $input, OutputInterface $output)[m
[32m+[m[32m    {[m
[32m+[m[32m        $user = new Utilisateur();[m
[32m+[m
[32m+[m[32m        $username = $input->getArgument('username');[m
[32m+[m
[32m+[m[32m        $email = $input->getArgument('email');[m
[32m+[m
[32m+[m[32m        $password = $input->getArgument('password');[m
[32m+[m[32m        $password = $this->passwordEncoder->encodePassword($user, $password);[m
[32m+[m
[32m+[m[32m        $user->setUsername($username);[m
[32m+[m[32m        $user->setEmail($email);[m
[32m+[m[32m        $user->setPassword($password);[m
[32m+[m
[32m+[m[32m        $errors = $this->validator->validate($user);[m
[32m+[m
[32m+[m[32m        if (count($errors) > 0) {[m
[32m+[m[32m            $errorsString = (string) $errors;[m
[32m+[m[32m            throw new \Exception($errorsString);[m
[32m+[m[32m        }[m
[32m+[m
[32m+[m
[32m+[m[32m        $this->em->persist($user);[m
[32m+[m[32m        $this->em->flush();[m
[32m+[m
[32m+[m[32m        $output->writeln(sprintf('Created user %s', $username));[m
[32m+[m[32m    }[m
[32m+[m
[32m+[m[32m    /**[m
[32m+[m[32m     *      * {@inheritdoc}[m
[32m+[m[32m     *           */[m
[32m+[m[32m    protected function interact(InputInterface $input, OutputInterface $output)[m
[32m+[m[32m    {[m
[32m+[m[32m        $questions = array();[m
[32m+[m
[32m+[m[32m        if (!$input->getArgument('username')) {[m
[32m+[m[32m            $question = new Question('Please choose a username:');[m
[32m+[m[32m            $questions['username'] = $question;[m
[32m+[m[32m        }[m
[32m+[m
[32m+[m[32m        if (!$input->getArgument('email')) {[m
[32m+[m[32m            $question = new Question('Please choose an email:');[m
[32m+[m[32m            $questions['email'] = $question;[m
[32m+[m[32m        }[m
[32m+[m
[32m+[m[32m        if (!$input->getArgument('password')) {[m
[32m+[m[32m            $question = new Question('Please choose a password:');[m
[32m+[m[32m            $question->setHidden(true);[m
[32m+[m[32m            $question->setHiddenFallback(false);[m
[32m+[m[32m            $questions['password'] = $question;[m
[32m+[m[32m        }[m
[32m+[m
[32m+[m[32m        foreach ($questions as $name => $question) {[m
[32m+[m[32m            $answer = $this->getHelper('question')->ask($input, $output, $question);[m
[32m+[m[32m            $input->setArgument($name, $answer);[m
[32m+[m[32m        }[m
[32m+[m[32m    }[m
[32m+[m[32m}[m
[1mdiff --git a/src/Command/SetRoleUserCommand.php b/src/Command/SetRoleUserCommand.php[m
[1mnew file mode 100644[m
[1mindex 0000000..533905d[m
[1m--- /dev/null[m
[1m+++ b/src/Command/SetRoleUserCommand.php[m
[36m@@ -0,0 +1,88 @@[m
[32m+[m[32m<?php[m
[32m+[m
[32m+[m[32mnamespace App\Command;[m
[32m+[m
[32m+[m[32muse Symfony\Component\Console\Input\InputArgument;[m
[32m+[m[32muse Symfony\Component\Console\Input\InputInterface;[m
[32m+[m[32muse Symfony\Component\Console\Input\InputOption;[m
[32m+[m[32muse Symfony\Component\Console\Output\OutputInterface;[m
[32m+[m[32muse Symfony\Component\Console\Question\Question;[m
[32m+[m[32muse Symfony\Component\Console\Command\Command;[m
[32m+[m[32muse Doctrine\ORM\EntityManagerInterface;[m
[32m+[m[32muse App\Entity\Utilisateur;[m
[32m+[m[32muse Symfony\Component\Validator\Validator\ValidatorInterface;[m
[32m+[m
[32m+[m[32mclass SetRoleUserCommand extends Command[m
[32m+[m[32m{[m
[32m+[m[32m    private $em;[m
[32m+[m
[32m+[m[32m    private $validator;[m
[32m+[m
[32m+[m[32m    public function __construct(EntityManagerInterface $em, ValidatorInterface $validator)[m
[32m+[m[32m    {[m
[32m+[m[32m        $this->em = $em;[m
[32m+[m[32m        $this->validator = $validator;[m
[32m+[m
[32m+[m[32m        parent::__construct();[m
[32m+[m[32m    }[m
[32m+[m
[32m+[m[32m    protected function configure()[m
[32m+[m[32m    {[m
[32m+[m[32m        $this[m
[32m+[m[32m            ->setName('app:set-role-user')[m
[32m+[m[32m            ->setDescription('Set the user\'s role.')[m
[32m+[m[32m            ->setDefinition(array([m
[32m+[m[32m                new InputArgument('username', InputArgument::REQUIRED, 'The username'),[m
[32m+[m[32m                new InputArgument('role', InputArgument::REQUIRED, 'New role'),[m
[32m+[m[32m            ))[m
[32m+[m[32m            ;[m
[32m+[m[32m    }[m
[32m+[m
[32m+[m[32m    /**[m
[32m+[m[32m     * {@inheritdoc}[m
[32m+[m[32m     */[m
[32m+[m[32m    protected function execute(InputInterface $input, OutputInterface $output)[m
[32m+[m[32m    {[m
[32m+[m[32m        $username = $input->getArgument('username');[m
[32m+[m
[32m+[m[32m        $user = $this->em->getRepository(Utilisateur::class)->findOneByUsername($username);[m
[32m+[m
[32m+[m[32m        $role = $input->getArgument('role');[m
[32m+[m
[32m+[m[32m        $roles = $user->setRoles([$role]);[m
[32m+[m
[32m+[m[32m        $errors = $this->validator->validate($user);[m
[32m+[m
[32m+[m[32m        if (count($errors) > 0) {[m
[32m+[m[32m            $errorsString = (string) $errors;[m
[32m+[m[32m            throw new \Exception($errorsString);[m
[32m+[m[32m        }[m
[32m+[m
[32m+[m[32m        $this->em->flush();[m
[32m+[m
[32m+[m[32m        $output->writeln(sprintf('New role defined for %s', $username));[m
[32m+[m[32m    }[m
[32m+[m
[32m+[m[32m    /**[m
[32m+[m[32m     * {@inheritdoc}[m
[32m+[m[32m     */[m
[32m+[m[32m    protected function interact(InputInterface $input, OutputInterface $output)[m
[32m+[m[32m    {[m
[32m+[m[32m        $questions = array();[m
[32m+[m
[32m+[m[32m        if (!$input->getArgument('username')) {[m
[32m+[m[32m            $question = new Question('The username of the existing user:');[m
[32m+[m[32m            $questions['username'] = $question;[m
[32m+[m[32m        }[m
[32m+[m
[32m+[m[32m        if (!$input->getArgument('role')) {[m
[32m+[m[32m            $question = new Question('New role:');[m
[32m+[m[32m            $questions['role'] = $question;[m
[32m+[m[32m        }[m
[32m+[m
[32m+[m[32m        foreach ($questions as $name => $question) {[m
[32m+[m[32m            $answer = $this->getHelper('question')->ask($input, $output, $question);[m
[32m+[m[32m            $input->setArgument($name, $answer);[m
[32m+[m[32m        }[m
[32m+[m[32m    }[m
[32m+[m[32m}[m
[1mdiff --git a/src/Entity/Utilisateur.php b/src/Entity/Utilisateur.php[m
[1mindex 0d4c542..460ee06 100644[m
[1m--- a/src/Entity/Utilisateur.php[m
[1m+++ b/src/Entity/Utilisateur.php[m
[36m@@ -6,153 +6,184 @@[m [muse ApiPlatform\Core\Annotation\ApiResource;[m
 use Doctrine\ORM\Mapping as ORM;[m
 use Symfony\Component\Security\Core\User\UserInterface;[m
 use Symfony\Component\Validator\Constraints as Assert;[m
[32m+[m[32muse Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;[m
 [m
 /**[m
  * @ApiResource()[m
  * @ORM\Entity(repositoryClass="App\Repository\UtilisateurRepository")[m
[32m+[m[32m * @UniqueEntity(fields="email", message="Cet email est déjà enregistré en base.")[m
[32m+[m[32m * @UniqueEntity(fields="username", message="Cet identifiant est déjà enregistré en base")[m
  */[m
 class Utilisateur implements UserInterface, \Serializable[m
 {[m
     /**[m
[31m-     * @ORM\Id()[m
[31m-     * @ORM\GeneratedValue()[m
      * @ORM\Column(type="integer")[m
[32m+[m[32m     * @ORM\Id[m
[32m+[m[32m     * @ORM\GeneratedValue(strategy="AUTO")[m
      */[m
     private $id;[m
[31m-[m
[31m-    /**[m
[31m-     * @ORM\Column(type="string", length=25)[m
[31m-     */[m
[31m-    private $username;[m
[31m-[m
[32m+[m[41m [m
     /**[m
[32m+[m[32m     * @ORM\Column(type="string", length=25, unique=true)[m
      * @Assert\NotBlank()[m
[31m-     * @Assert\Length(max=250)[m
[32m+[m[32m     * @Assert\Length(max=25)[m
      */[m
[31m-    private $plainPassword;[m
[31m-[m
[32m+[m[32m    private $username;[m
[32m+[m[41m [m
     /**[m
[31m-     * The below length depends on the "algorithm" you use for encoding[m
[31m-     * the password, but this works well with bcrypt.[m
[31m-     *[m
      * @ORM\Column(type="string", length=64)[m
      */[m
     private $password;[m
[31m-[m
[32m+[m[41m [m
     /**[m
[31m-     * @ORM\Column(type="string", length=255)[m
[32m+[m[32m     * @ORM\Column(type="string", length=60, unique=true)[m
[32m+[m[32m     * @Assert\NotBlank()[m
[32m+[m[32m     * @Assert\Length(max=60)[m
[32m+[m[32m     * @Assert\Email()[m
      */[m
     private $email;[m
[31m-[m
[32m+[m[41m [m
     /**[m
[31m-     * @ORM\Column(type="boolean")[m
[32m+[m[32m     * @ORM\Column(name="is_active", type="boolean")[m
      */[m
     private $isActive;[m
[32m+[m[41m    [m
[32m+[m[32m     /**[m
[32m+[m[32m     * @var array[m
[32m+[m[32m     * @ORM\Column(type="array")[m
[32m+[m[32m     */[m
[32m+[m[32m    private $roles;[m
 [m
[31m-   [m
[31m-    public function __construct() {[m
[32m+[m[32m    public function __construct()[m
[32m+[m[32m    {[m
         $this->isActive = true;[m
[31m-        // may not be needed, see section on salt below[m
[31m-        // $this->salt = md5(uniqid('', true));[m
[31m-    }[m
[31m-[m
[31m-    public function getUsername() {[m
[31m-        return $this->username;[m
[31m-    }[m
[31m-[m
[31m-    public function getSalt() {[m
[31m-        // you *may* need a real salt depending on your encoder[m
[31m-        // see section on salt below[m
[31m-        return null;[m
[31m-    }[m
[31m-[m
[31m-    public function getPassword() {[m
[31m-        return $this->password;[m
[31m-    }[m
[31m-[m
[31m-    function setPassword($password) {[m
[31m-        $this->password = $password;[m
[31m-    }[m
[31m-[m
[31m-    public function getRoles() {[m
[31m-       // if (empty($this->roles)) {[m
[31m-         //   return ['ROLE_USER'];[m
[31m-       // }[m
[31m-       // return $this->roles;[m
[31m-[m
[31m-       return array('ROLE_USER');[m
[32m+[m[32m        $this->roles = ['ROLE_USER'];[m
     }[m
[31m-[m
[31m-    /*function addRole($role) {[m
[31m-        $this->roles[] = $role;[m
[31m-    }*/[m
[31m-[m
[31m-    public function eraseCredentials() {[m
[31m-        [m
[32m+[m[41m     [m
[32m+[m[32m    /*[m
[32m+[m[32m     * Get id[m
[32m+[m[32m     */[m
[32m+[m[32m    public function getId()[m
[32m+[m[32m    {[m
[32m+[m[32m        return $this->id;[m
     }[m
[31m-[m
[31m-    /** @see \Serializable::serialize() */[m
[31m-    public function serialize() {[m
[31m-        return serialize(array([m
[31m-            $this->id,[m
[31m-            $this->username,[m
[31m-            $this->email,[m
[31m-            $this->password,[m
[31m-            $this->isActive,[m
[31m-                // see section on salt below[m
[31m-                // $this->salt,[m
[31m-        ));[m
[32m+[m[41m [m
[32m+[m[32m    public function getUsername()[m
[32m+[m[32m    {[m
[32m+[m[32m        return $this->username;[m
     }[m
[31m-[m
[31m-    /** @see \Serializable::unserialize() */[m
[31m-    public function unserialize($serialized) {[m
[31m-        list ([m
[31m-                $this->id,[m
[31m-                $this->username,[m
[31m-                $this->email,[m
[31m-                $this->password,[m
[31m-                $this->isActive,[m
[31m-                // see section on salt below[m
[31m-                // $this->salt[m
[31m-                ) = unserialize($serialized);[m
[32m+[m[41m [m
[32m+[m[32m    public function setUsername($username)[m
[32m+[m[32m    {[m
[32m+[m[32m        $this->username = $username;[m
[32m+[m[32m        return $this;[m
     }[m
[31m-[m
[31m-    public function getId(): ?int[m
[32m+[m[41m [m
[32m+[m[41m [m
[32m+[m[32m    public function getPassword()[m
     {[m
[31m-        return $this->id;[m
[32m+[m[32m        return $this->password;[m
     }[m
[31m-[m
[31m-    public function setUsername(string $username): self[m
[32m+[m[41m [m
[32m+[m[32m    public function setPassword($password)[m
     {[m
[31m-        $this->username = $username;[m
[31m-[m
[32m+[m[32m        $this->password = $password;[m
         return $this;[m
     }[m
[31m-[m
[31m-    public function getEmail(): ?string[m
[32m+[m[41m [m
[32m+[m[32m    /*[m
[32m+[m[32m     * Get email[m
[32m+[m[32m     */[m
[32m+[m[32m    public function getEmail()[m
     {[m
         return $this->email;[m
     }[m
[31m-[m
[31m-    public function setEmail(string $email): self[m
[32m+[m[41m [m
[32m+[m[32m    /*[m
[32m+[m[32m     * Set email[m
[32m+[m[32m     */[m
[32m+[m[32m    public function setEmail($email)[m
     {[m
         $this->email = $email;[m
[31m-[m
         return $this;[m
     }[m
[31m-[m
[31m-    public function getIsActive(): ?bool[m
[32m+[m[41m [m
[32m+[m[32m    /*[m
[32m+[m[32m     * Get isActive[m
[32m+[m[32m     */[m
[32m+[m[32m    public function getIsActive()[m
     {[m
         return $this->isActive;[m
     }[m
[31m-[m
[31m-    public function setIsActive(bool $isActive): self[m
[32m+[m[41m [m
[32m+[m[32m    /*[m
[32m+[m[32m     * Set isActive[m
[32m+[m[32m     */[m
[32m+[m[32m    public function setIsActive($isActive)[m
     {[m
         $this->isActive = $isActive;[m
[31m-[m
         return $this;[m
     }[m
 [m
[31m-    [m
[32m+[m[32m     // modifier la méthode getRoles[m
[32m+[m[32m     public function getRoles()[m
[32m+[m[32m     {[m
[32m+[m[32m         return $this->roles;[m[41m [m
[32m+[m[32m     }[m
[32m+[m
[32m+[m[32m     public function setRoles(array $roles)[m
[32m+[m[32m     {[m
[32m+[m[32m         if (!in_array('ROLE_USER', $roles))[m
[32m+[m[32m         {[m
[32m+[m[32m             $roles[] = 'ROLE_USER';[m
[32m+[m[32m         }[m
[32m+[m[32m         foreach ($roles as $role)[m
[32m+[m[32m         {[m
[32m+[m[32m             if(substr($role, 0, 5) !== 'ROLE_') {[m
[32m+[m[32m                 throw new InvalidArgumentException("Chaque rôle doit commencer par 'ROLE_'");[m
[32m+[m[32m             }[m
[32m+[m[32m         }[m
[32m+[m[32m         $this->roles = $roles;[m
[32m+[m[32m         return $this;[m
[32m+[m[32m     }[m
[32m+[m[41m [m
[32m+[m[32m    public function getSalt()[m
[32m+[m[32m    {[m
[32m+[m[32m        // pas besoin de salt puisque nous allons utiliser bcrypt[m
[32m+[m[32m        // attention si vous utilisez une méthode d'encodage différente ![m
[32m+[m[32m        // il faudra décommenter les lignes concernant le salt, créer la propriété correspondante, et renvoyer sa valeur dans cette méthode[m
[32m+[m[32m        return null;[m
[32m+[m[32m    }[m
[32m+[m[41m [m
[32m+[m[32m    public function eraseCredentials()[m
[32m+[m[32m    {[m
[32m+[m[32m    }[m
[32m+[m[41m [m
[32m+[m[32m    /** @see \Serializable::serialize() */[m
[32m+[m[32m    public function serialize()[m
[32m+[m[32m    {[m
[32m+[m[32m        return serialize(array([m
[32m+[m[32m            $this->id,[m
[32m+[m[32m            $this->username,[m
[32m+[m[32m            $this->password,[m
[32m+[m[32m            $this->isActive,[m
[32m+[m[32m            // voir remarques sur salt plus haut[m
[32m+[m[32m            // $this->salt,[m
[32m+[m[32m        ));[m
[32m+[m[32m    }[m
[32m+[m[41m [m
[32m+[m[32m    /** @see \Serializable::unserialize() */[m
[32m+[m[32m    public function unserialize($serialized)[m
[32m+[m[32m    {[m
[32m+[m[32m        list ([m
[32m+[m[32m            $this->id,[m
[32m+[m[32m            $this->username,[m
[32m+[m[32m            $this->password,[m
[32m+[m[32m            $this->isActive,[m
[32m+[m[32m            // voir remarques sur salt plus haut[m
[32m+[m[32m            // $this->salt[m
[32m+[m[32m        ) = unserialize($serialized);[m
[32m+[m[32m    }[m
[32m+[m[41m        [m
 [m
 }[m
[1mdiff --git a/src/Entity/UtilisateurChecker.php b/src/Entity/UtilisateurChecker.php[m
[1mindex 4fe7f41..42b8554 100644[m
[1m--- a/src/Entity/UtilisateurChecker.php[m
[1m+++ b/src/Entity/UtilisateurChecker.php[m
[36m@@ -15,22 +15,17 @@[m [mclass UtilisateurChecker implements UserCheckerInterface[m
         if (!$user instanceof AppUser) {[m
             return;[m
         }[m
[31m-[m
[31m-        // user is deleted, show a generic Account Not Found message.[m
[31m-        if ($user->isDeleted()) {[m
[31m-            throw new AccountDeletedException('...');[m
[31m-        }[m
     }[m
[31m-[m
[32m+[m[41m [m
     public function checkPostAuth(UserInterface $user)[m
     {[m
         if (!$user instanceof AppUser) {[m
             return;[m
         }[m
[31m-[m
[32m+[m[41m [m
         // user account is expired, the user may be notified[m
[31m-        if ($user->isExpired()) {[m
[31m-            throw new AccountExpiredException('...');[m
[32m+[m[32m        if (!$user->getIsActive()) {[m
[32m+[m[32m            throw new \Exception("ce membre n'est pas actif");[m
         }[m
     }[m
 }[m
[1mdiff --git a/src/Migrations/.gitignore b/src/Migrations/.gitignore[m
[1mdeleted file mode 100644[m
[1mindex e69de29..0000000[m
[1mdiff --git a/src/Migrations/Version20180720112503.php b/src/Migrations/Version20180720112503.php[m
[1mdeleted file mode 100644[m
[1mindex 6f8eabd..0000000[m
[1m--- a/src/Migrations/Version20180720112503.php[m
[1m+++ /dev/null[m
[36m@@ -1,28 +0,0 @@[m
[31m-<?php declare(strict_types=1);[m
[31m-[m
[31m-namespace DoctrineMigrations;[m
[31m-[m
[31m-use Doctrine\DBAL\Schema\Schema;[m
[31m-use Doctrine\Migrations\AbstractMigration;[m
[31m-[m
[31m-/**[m
[31m- * Auto-generated Migration: Please modify to your needs![m
[31m- */[m
[31m-final class Version20180720112503 extends AbstractMigration[m
[31m-{[m
[31m-    public function up(Schema $schema) : void[m
[31m-    {[m
[31m-        // this up() migration is auto-generated, please modify it to your needs[m
[31m-        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');[m
[31m-[m
[31m-        $this->addSql('DROP TABLE operations_es');[m
[31m-    }[m
[31m-[m
[31m-    public function down(Schema $schema) : void[m
[31m-    {[m
[31m-        // this down() migration is auto-generated, please modify it to your needs[m
[31m-        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');[m
[31m-[m
[31m-        $this->addSql('CREATE TABLE operations_es (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');[m
[31m-    }[m
[31m-}[m
[1mdiff --git a/src/Migrations/Version20180811130106.php b/src/Migrations/Version20180811130106.php[m
[1mdeleted file mode 100644[m
[1mindex 159b861..0000000[m
[1m--- a/src/Migrations/Version20180811130106.php[m
[1m+++ /dev/null[m
[36m@@ -1,50 +0,0 @@[m
[31m-<?php declare(strict_types=1);[m
[31m-[m
[31m-namespace DoctrineMigrations;[m
[31m-[m
[31m-use Doctrine\DBAL\Schema\Schema;[m
[31m-use Doctrine\Migrations\AbstractMigration;[m
[31m-[m
[31m-/**[m
[31m- * Auto-generated Migration: Please modify to your needs![m
[31m- */[m
[31m-final class Version20180811130106 extends AbstractMigration[m
[31m-{[m
[31m-    public function up(Schema $schema) : void[m
[31m-    {[m
[31m-        // this up() migration is auto-generated, please modify it to your needs[m
[31m-        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');[m
[31m-[m
[31m-        $this->addSql('ALTER TABLE commission_participant DROP FOREIGN KEY FK_FE1548C9D1C3019');[m
[31m-        $this->addSql('ALTER TABLE detail_program_participant DROP FOREIGN KEY FK_19CDE85B9D1C3019');[m
[31m-        $this->addSql('ALTER TABLE participer DROP FOREIGN KEY FK_EDBE16F89D1C3019');[m
[31m-        $this->addSql('ALTER TABLE transaction_fin DROP FOREIGN KEY FK_566A47F89D1C3019');[m
[31m-        $this->addSql('DROP TABLE commission_participant');[m
[31m-        $this->addSql('DROP TABLE detail_program_participant');[m
[31m-        $this->addSql('DROP TABLE participant');[m
[31m-        $this->addSql('DROP INDEX IDX_EDBE16F89D1C3019 ON participer');[m
[31m-        $this->addSql('ALTER TABLE participer DROP participant_id');[m
[31m-        $this->addSql('DROP INDEX IDX_566A47F89D1C3019 ON transaction_fin');[m
[31m-        $this->addSql('ALTER TABLE transaction_fin DROP participant_id');[m
[31m-    }[m
[31m-[m
[31m-    public function down(Schema $schema) : void[m
[31m-    {[m
[31m-        // this down() migration is auto-generated, please modify it to your needs[m
[31m-        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');[m
[31m-[m
[31m-        $this->addSql('CREATE TABLE commission_participant (commission_id INT NOT NULL, participant_id INT NOT NULL, INDEX IDX_FE1548C202D1EB2 (commission_id), INDEX IDX_FE1548C9D1C3019 (participant_id), PRIMARY KEY(commission_id, participant_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');[m
[31m-        $this->addSql('CREATE TABLE detail_program_participant (detail_program_id INT NOT NULL, participant_id INT NOT NULL, INDEX IDX_19CDE85B85A2B7DC (detail_program_id), INDEX IDX_19CDE85B9D1C3019 (participant_id), PRIMARY KEY(detail_program_id, participant_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');[m
[31m-        $this->addSql('CREATE TABLE participant (id INT AUTO_INCREMENT NOT NULL, nom_prenom VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, telephone1 VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, telephone2 VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, adresse1 VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, adresse2 VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, mail VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, onlin_registered TINYINT(1) NOT NULL, anonyme1 VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, anonyme2 VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, anonyme3 VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, anonyme4 VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, anonyme5 VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, anonyme6 VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, anonyme7 VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, anonyme8 VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, anonyme9 VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, anonyme10 VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');[m
[31m-        $this->addSql('ALTER TABLE commission_participant ADD CONSTRAINT FK_FE1548C202D1EB2 FOREIGN KEY (commission_id) REFERENCES commission (id) ON DELETE CASCADE');[m
[31m-        $this->addSql('ALTER TABLE commission_participant ADD CONSTRAINT FK_FE1548C9D1C3019 FOREIGN KEY (participant_id) REFERENCES participant (id) ON DELETE CASCADE');[m
[31m-        $this->addSql('ALTER TABLE detail_program_participant ADD CONSTRAINT FK_19CDE85B85A2B7DC FOREIGN KEY (detail_program_id) REFERENCES detail_program (id) ON DELETE CASCADE');[m
[31m-        $this->addSql('ALTER TABLE detail_program_participant ADD CONSTRAINT FK_19CDE85B9D1C3019 FOREIGN KEY (participant_id) REFERENCES participant (id) ON DELETE CASCADE');[m
[31m-        $this->addSql('ALTER TABLE participer ADD participant_id INT DEFAULT NULL');[m
[31m-        $this->addSql('ALTER TABLE participer ADD CONSTRAINT FK_EDBE16F89D1C3019 FOREIGN KEY (participant_id) REFERENCES participant (id)');[m
[31m-        $this->addSql('CREATE INDEX IDX_EDBE16F89D1C3019 ON participer (participant_id)');[m
[31m-        $this->addSql('ALTER TABLE transaction_fin ADD participant_id INT DEFAULT NULL');[m
[31m-        $this->addSql('ALTER TABLE transaction_fin ADD CONSTRAINT FK_566A47F89D1C3019 FOREIGN KEY (participant_id) REFERENCES participant (id)');[m
[31m-        $this->addSql('CREATE INDEX IDX_566A47F89D1C3019 ON transaction_fin (participant_id)');[m
[31m-    }[m
[31m-}[m
[1mdiff --git a/src/Migrations/Version20180811142023.php b/src/Migrations/Version20180811142023.php[m
[1mdeleted file mode 100644[m
[1mindex 4f8c44e..0000000[m
[1m--- a/src/Migrations/Version20180811142023.php[m
[1m+++ /dev/null[m
[36m@@ -1,52 +0,0 @@[m
[31m-<?php declare(strict_types=1);[m
[31m-[m
[31m-namespace DoctrineMigrations;[m
[31m-[m
[31m-use Doctrine\DBAL\Schema\Schema;[m
[31m-use Doctrine\Migrations\AbstractMigration;[m
[31m-[m
[31m-/**[m
[31m- * Auto-generated Migration: Please modify to your needs![m
[31m- */[m
[31m-final class Version20180811142023 extends AbstractMigration[m
[31m-{[m
[31m-    public function up(Schema $schema) : void[m
[31m-    {[m
[31m-        // this up() migration is auto-generated, please modify it to your needs[m
[31m-        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');[m
[31m-[m
[31m-        $this->addSql('CREATE TABLE contact (id INT AUTO_INCREMENT NOT NULL, nom_prenom VARCHAR(255) NOT NULL, mail VARCHAR(255) DEFAULT NULL, telephone1 VARCHAR(255) DEFAULT NULL, telephone2 VARCHAR(255) DEFAULT NULL, adresse1 VARCHAR(255) DEFAULT NULL, adresse2 VARCHAR(255) DEFAULT NULL, online_registered TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');[m
[31m-        $this->addSql('CREATE TABLE contact_detail_program (contact_id INT NOT NULL, detail_program_id INT NOT NULL, INDEX IDX_86DF7991E7A1254A (contact_id), INDEX IDX_86DF799185A2B7DC (detail_program_id), PRIMARY KEY(contact_id, detail_program_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');[m
[31m-        $this->addSql('CREATE TABLE contact_commission (contact_id INT NOT NULL, commission_id INT NOT NULL, INDEX IDX_DBDC58CFE7A1254A (contact_id), INDEX IDX_DBDC58CF202D1EB2 (commission_id), PRIMARY KEY(contact_id, commission_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');[m
[31m-        $this->addSql('ALTER TABLE contact_detail_program ADD CONSTRAINT FK_86DF7991E7A1254A FOREIGN KEY (contact_id) REFERENCES contact (id) ON DELETE CASCADE');[m
[31m-        $this->addSql('ALTER TABLE contact_detail_program ADD CONSTRAINT FK_86DF799185A2B7DC FOREIGN KEY (detail_program_id) REFERENCES detail_program (id) ON DELETE CASCADE');[m
[31m-        $this->addSql('ALTER TABLE contact_commission ADD CONSTRAINT FK_DBDC58CFE7A1254A FOREIGN KEY (contact_id) REFERENCES contact (id) ON DELETE CASCADE');[m
[31m-        $this->addSql('ALTER TABLE contact_commission ADD CONSTRAINT FK_DBDC58CF202D1EB2 FOREIGN KEY (commission_id) REFERENCES commission (id) ON DELETE CASCADE');[m
[31m-        $this->addSql('ALTER TABLE participer ADD contact_id INT NOT NULL, ADD online_registered TINYINT(1) NOT NULL');[m
[31m-        $this->addSql('ALTER TABLE participer ADD CONSTRAINT FK_EDBE16F8E7A1254A FOREIGN KEY (contact_id) REFERENCES contact (id)');[m
[31m-        $this->addSql('CREATE INDEX IDX_EDBE16F8E7A1254A ON participer (contact_id)');[m
[31m-        $this->addSql('ALTER TABLE programme DROP anonyme1, DROP anonyme2, DROP anonyme3, DROP anonyme4, DROP anonyme5');[m
[31m-        $this->addSql('ALTER TABLE transaction_fin ADD contact_id INT NOT NULL, ADD payement_form SMALLINT NOT NULL, ADD ref_number VARCHAR(255) DEFAULT NULL, ADD auther_pay_method_name VARCHAR(255) DEFAULT NULL');[m
[31m-        $this->addSql('ALTER TABLE transaction_fin ADD CONSTRAINT FK_566A47F8E7A1254A FOREIGN KEY (contact_id) REFERENCES contact (id)');[m
[31m-        $this->addSql('CREATE INDEX IDX_566A47F8E7A1254A ON transaction_fin (contact_id)');[m
[31m-    }[m
[31m-[m
[31m-    public function down(Schema $schema) : void[m
[31m-    {[m
[31m-        // this down() migration is auto-generated, please modify it to your needs[m
[31m-        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');[m
[31m-[m
[31m-        $this->addSql('ALTER TABLE contact_detail_program DROP FOREIGN KEY FK_86DF7991E7A1254A');[m
[31m-        $this->addSql('ALTER TABLE contact_commission DROP FOREIGN KEY FK_DBDC58CFE7A1254A');[m
[31m-        $this->addSql('ALTER TABLE participer DROP FOREIGN KEY FK_EDBE16F8E7A1254A');[m
[31m-        $this->addSql('ALTER TABLE transaction_fin DROP FOREIGN KEY FK_566A47F8E7A1254A');[m
[31m-        $this->addSql('DROP TABLE contact');[m
[31m-        $this->addSql('DROP TABLE contact_detail_program');[m
[31m-        $this->addSql('DROP TABLE contact_commission');[m
[31m-        $this->addSql('DROP INDEX IDX_EDBE16F8E7A1254A ON participer');[m
[31m-        $this->addSql('ALTER TABLE participer DROP contact_id, DROP online_registered');[m
[31m-        $this->addSql('ALTER TABLE programme ADD anonyme1 VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, ADD anonyme2 VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, ADD anonyme3 VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, ADD anonyme4 VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, ADD anonyme5 VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci');[m
[31m-        $this->addSql('DROP INDEX IDX_566A47F8E7A1254A ON transaction_fin');[m
[31m-        $this->addSql('ALTER TABLE transaction_fin DROP contact_id, DROP payement_form, DROP ref_number, DROP auther_pay_method_name');[m
[31m-    }[m
[31m-}[m
[1mdiff --git a/src/Migrations/Version20180811143636.php b/src/Migrations/Version20180811143636.php[m
[1mdeleted file mode 100644[m
[1mindex 4841138..0000000[m
[1m--- a/src/Migrations/Version20180811143636.php[m
[1m+++ /dev/null[m
[36m@@ -1,31 +0,0 @@[m
[31m-<?php declare(strict_types=1);[m
[31m-[m
[31m-namespace DoctrineMigrations;[m
[31m-[m
[31m-use Doctrine\DBAL\Schema\Schema;[m
[31m-use Doctrine\Migrations\AbstractMigration;[m
[31m-[m
[31m-/**[m
[31m- * Auto-generated Migration: Please modify to your needs![m
[31m- */[m
[31m-final class Version20180811143636 extends AbstractMigration[m
[31m-{[m
[31m-    public function up(Schema $schema) : void[m
[31m-    {[m
[31m-        // this up() migration is auto-generated, please modify it to your needs[m
[31m-        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');[m
[31m-[m
[31m-        $this->addSql('CREATE TABLE anonyme_field (id INT AUTO_INCREMENT NOT NULL, seminaire_id INT DEFAULT NULL, programme_id INT DEFAULT NULL, contact_id INT DEFAULT NULL, libelle VARCHAR(255) NOT NULL, valeur VARCHAR(255) DEFAULT NULL, INDEX IDX_BF1F07B3CEA14D8 (seminaire_id), INDEX IDX_BF1F07B362BB7AEE (programme_id), INDEX IDX_BF1F07B3E7A1254A (contact_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');[m
[31m-        $this->addSql('ALTER TABLE anonyme_field ADD CONSTRAINT FK_BF1F07B3CEA14D8 FOREIGN KEY (seminaire_id) REFERENCES seminaire (id)');[m
[31m-        $this->addSql('ALTER TABLE anonyme_field ADD CONSTRAINT FK_BF1F07B362BB7AEE FOREIGN KEY (programme_id) REFERENCES programme (id)');[m
[31m-        $this->addSql('ALTER TABLE anonyme_field ADD CONSTRAINT FK_BF1F07B3E7A1254A FOREIGN KEY (contact_id) REFERENCES contact (id)');[m
[31m-    }[m
[31m-[m
[31m-    public function down(Schema $schema) : void[m
[31m-    {[m
[31m-        // this down() migration is auto-generated, please modify it to your needs[m
[31m-        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');[m
[31m-[m
[31m-        $this->addSql('DROP TABLE anonyme_field');[m
[31m-    }[m
[31m-}[m
[1mdiff --git a/src/Migrations/Version20180815132640.php b/src/Migrations/Version20180815132640.php[m
[1mdeleted file mode 100644[m
[1mindex 5678351..0000000[m
[1m--- a/src/Migrations/Version20180815132640.php[m
[1m+++ /dev/null[m
[36m@@ -1,28 +0,0 @@[m
[31m-<?php declare(strict_types=1);[m
[31m-[m
[31m-namespace DoctrineMigrations;[m
[31m-[m
[31m-use Doctrine\DBAL\Schema\Schema;[m
[31m-use Doctrine\Migrations\AbstractMigration;[m
[31m-[m
[31m-/**[m
[31m- * Auto-generated Migration: Please modify to your needs![m
[31m- */[m
[31m-final class Version20180815132640 extends AbstractMigration[m
[31m-{[m
[31m-    public function up(Schema $schema) : void[m
[31m-    {[m
[31m-        // this up() migration is auto-generated, please modify it to your needs[m
[31m-        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');[m
[31m-[m
[31m-        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(25) NOT NULL, motdepasse VARCHAR(64) NOT NULL, mail VARCHAR(255) NOT NULL, is_active TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');[m
[31m-    }[m
[31m-[m
[31m-    public function down(Schema $schema) : void[m
[31m-    {[m
[31m-        // this down() migration is auto-generated, please modify it to your needs[m
[31m-        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');[m
[31m-[m
[31m-        $this->addSql('DROP TABLE utilisateur');[m
[31m-    }[m
[31m-}[m
[1mdiff --git a/src/Migrations/Version20180816201130.php b/src/Migrations/Version20180816201130.php[m
[1mdeleted file mode 100644[m
[1mindex 995ec26..0000000[m
[1m--- a/src/Migrations/Version20180816201130.php[m
[1m+++ /dev/null[m
[36m@@ -1,28 +0,0 @@[m
[31m-<?php declare(strict_types=1);[m
[31m-[m
[31m-namespace DoctrineMigrations;[m
[31m-[m
[31m-use Doctrine\DBAL\Schema\Schema;[m
[31m-use Doctrine\Migrations\AbstractMigration;[m
[31m-[m
[31m-/**[m
[31m- * Auto-generated Migration: Please modify to your needs![m
[31m- */[m
[31m-final class Version20180816201130 extends AbstractMigration[m
[31m-{[m
[31m-    public function up(Schema $schema) : void[m
[31m-    {[m
[31m-        // this up() migration is auto-generated, please modify it to your needs[m
[31m-        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');[m
[31m-[m
[31m-        $this->addSql('ALTER TABLE contact DROP online_registered');[m
[31m-    }[m
[31m-[m
[31m-    public function down(Schema $schema) : void[m
[31m-    {[m
[31m-        // this down() migration is auto-generated, please modify it to your needs[m
[31m-        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');[m
[31m-[m
[31m-        $this->addSql('ALTER TABLE contact ADD online_registered TINYINT(1) NOT NULL');[m
[31m-    }[m
[31m-}[m
[1mdiff --git a/src/Migrations/Version20180820161949.php b/src/Migrations/Version20180820161949.php[m
[1mdeleted file mode 100644[m
[1mindex 6bad931..0000000[m
[1m--- a/src/Migrations/Version20180820161949.php[m
[1m+++ /dev/null[m
[36m@@ -1,28 +0,0 @@[m
[31m-<?php declare(strict_types=1);[m
[31m-[m
[31m-namespace DoctrineMigrations;[m
[31m-[m
[31m-use Doctrine\DBAL\Schema\Schema;[m
[31m-use Doctrine\Migrations\AbstractMigration;[m
[31m-[m
[31m-/**[m
[31m- * Auto-generated Migration: Please modify to your needs![m
[31m- */[m
[31m-final class Version20180820161949 extends AbstractMigration[m
[31m-{[m
[31m-    public function up(Schema $schema) : void[m
[31m-    {[m
[31m-        // this up() migration is auto-generated, please modify it to your needs[m
[31m-        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');[m
[31m-[m
[31m-        $this->addSql('ALTER TABLE utilisateur ADD roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', CHANGE motdepasse password VARCHAR(64) NOT NULL, CHANGE mail email VARCHAR(255) NOT NULL');[m
[31m-    }[m
[31m-[m
[31m-    public function down(Schema $schema) : void[m
[31m-    {[m
[31m-        // this down() migration is auto-generated, please modify it to your needs[m
[31m-        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');[m
[31m-[m
[31m-        $this->addSql('ALTER TABLE utilisateur DROP roles, CHANGE password motdepasse VARCHAR(64) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE email mail VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci');[m
[31m-    }[m
[31m-}[m
[1mdiff --git a/src/Repository/UtilisateurRepository.php b/src/Repository/UtilisateurRepository.php[m
[1mindex 694147c..bc5e2c7 100644[m
[1m--- a/src/Repository/UtilisateurRepository.php[m
[1m+++ b/src/Repository/UtilisateurRepository.php[m
[36m@@ -51,11 +51,23 @@[m [mclass UtilisateurRepository extends ServiceEntityRepository implements UserLoade[m
 [m
     public function loadUserByUsername($username)[m
     {[m
[31m-        return $this->createQueryBuilder('u')[m
[32m+[m[32m        /*return $this->createQueryBuilder('u')[m
[32m+[m[32m            ->where('u.id = 1')[m
[32m+[m[32m            ->getQuery()[m
[32m+[m[32m            ->getOneOrNullResult();*/[m
[32m+[m
[32m+[m[32m        /*return $this->createQueryBuilder('u')[m
             ->where('u.username = :username OR u.email = :email')[m
             ->setParameter('username', $username)[m
             ->setParameter('email', $username)[m
             ->getQuery()[m
[32m+[m[32m            ->getOneOrNullResult();*/[m
[32m+[m
[32m+[m[32m        return $this->createQueryBuilder('u')[m
[32m+[m[32m            ->where('u.username = :username OR u.email = :email')[m
[32m+[m[32m            ->setParameter('username',  $username)[m
[32m+[m[32m            ->setParameter('email', $username)[m
[32m+[m[32m            ->getQuery()[m
             ->getOneOrNullResult();[m
     }[m
 }[m
