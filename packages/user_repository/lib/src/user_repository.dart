import 'package:user_repository/src/models/models.dart';
import 'package:uuid/uuid.dart';

/// Gère l'accès et la création des utilisateurs
class UserRepository {
  /// Représente l'utilisateur actuelle. Est initialisé null
  User? _user;

  /// Getter pour l'utilisateur actuel, crée un nouvel utilisateur si null
  Future<User?> getUser() async {
    if (_user != null) return _user;

    return Future.delayed(
      const Duration(milliseconds: 300),
        () => _user = User(const Uuid().v4()),
    );
  }
}