import 'package:formz/formz.dart';

enum PasswordValidationError { empty/*, notEnough*/ }

/// Modèle de [Password] standard et réutilisable
class Password extends FormzInput<String, PasswordValidationError> {
  const Password.pure() : super.pure('');

  const Password.dirty([super.value = '']) : super.dirty();

  /// Valide que le champ username n'est pas vide
  /// TODO restore the 'notEnough' parameter and make sure it works
  @override
  PasswordValidationError? validator(String value) {
    if (value.isEmpty) return PasswordValidationError.empty;
    //if (value.length < 8) return PasswordValidationError.notEnough;
    return null;
  }
}
