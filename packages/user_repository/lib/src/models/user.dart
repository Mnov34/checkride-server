import 'package:equatable/equatable.dart';

/// Classe représentant un utilisateur.
class User extends Equatable {
  /// Constructeur
  const User(this.id);

  final String id;

  /// Override (Cela veux dire en quelque sorte "remplace") la méthode get de Equatable
  /// Sert a faire une comparaison d'égalité simple car les comparaisons ne sont pas si simple en
  /// flutter vanilla
  @override
  List<Object> get props => [id];

  static const empty = User('-');
}