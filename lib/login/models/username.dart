import 'package:formz/formz.dart';

enum UsernameValidationError { empty/*, notEnough*/ }

/// Modèle de [Username] standard et réutilisable
class Username extends FormzInput<String, UsernameValidationError> {
  const Username.pure() : super.pure('');

  const Username.dirty([super.value = '']) : super.dirty();

  /// Valide que le champ username n'est pas vide
  /// TODO restore the 'notEnough' parameter and make sure it works
  @override
  UsernameValidationError? validator(String value) {
    if (value.isEmpty) return UsernameValidationError.empty;
    //if (value.length <= 3) return UsernameValidationError.notEnough;
    return null;
  }
}
