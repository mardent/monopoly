<?php
	interface IException {};
		interface IInternalException extends IException{};
			interface IFilesException extends IInternalException{
				public function Error();
			};
			interface IVriableException extends IInternalException{};
			interface IDataBaseException extends IInternalException{};
		interface IUserException extends IException{};	

?>