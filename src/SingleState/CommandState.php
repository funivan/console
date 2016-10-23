<?

  namespace Funivan\Console\SingleState;

  use Symfony\Component\Console\Command\Command;

  /**
   * Command status
   * According to name we check if command is running
   *
   * @author Ivan Shcherbak <dev@funivan.com>
   */
  class CommandState {

    /**
     * @var string
     */
    protected $pidFile;


    /**
     * Unique file name pid file name.
     *
     * @param Command $command
     * @param null|string $tmpDirectory
     */
    public function __construct(Command $command, $tmpDirectory = null) {
      $tmpDirectory = $tmpDirectory ? $tmpDirectory : sys_get_temp_dir();

      if (!is_dir($tmpDirectory) or !is_writable($tmpDirectory)) {
        throw new \RuntimeException(sprintf('The directory "%s" is not writable.', $tmpDirectory), 0, null, $tmpDirectory);
      }

      $partName = preg_replace('/[^a-z0-9\._-]+/i', '-', $command->getName());
      $partName = substr($partName, 0, 40);

      $this->pidFile = sprintf('%s/atl.%s.%s.pid', $tmpDirectory, $partName, hash('sha256', $command->getName()));
    }


    /**
     * @return bool
     * @throws \Exception
     */
    public function isAlive() {
      $pid = $this->getPid();

      if ($pid === null) {
        return false;
      }

      $result = exec('ps aux | awk \'{print $2}\' | grep "^' . $pid . '$"');

      return !empty($result);

    }


    /**
     * @param $pid
     * @return $this
     */
    public function setPid($pid) {

      if (!is_integer($pid)) {
        throw new \InvalidArgumentException("Invalid pid format. Expect only digits. Pid:" . $pid);
      }

      file_put_contents($this->pidFile, $pid);
      return $this;
    }


    /**
     * @return null|int
     * @throws \Exception
     */
    public function getPid() {
      if (!is_file($this->pidFile)) {
        return null;
      }

      $data = @file_get_contents($this->pidFile);
      if (empty($data)) {
        return null;
      }

      $data = trim($data);
      $pid = (int) $data;
      if ($pid != $data) {
        throw new \RuntimeException("File corrupted. Invalid pid format. File path:" . $this->getPidFilePath());
      }

      return $pid;
    }


    /**
     * Remove pid file
     *
     * @return bool
     */
    public function unlink() {
      if (is_file($this->pidFile)) {
        unlink($this->pidFile);
      }
      return true;
    }


    /**
     * @return string
     */
    public function getPidFilePath() {
      return $this->pidFile;
    }

  }
